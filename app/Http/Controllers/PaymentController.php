<?php

namespace App\Http\Controllers;

use App\Models\EfiCharge;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produto;
use App\Services\EfiCobrancasService;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $cartItems = Cart::session($userId)->getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('show.carrinho')->with('erro', 'Carrinho vazio');
        }

        $method = $request->input('payment_method', 'pix');
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'payment_method' => 'required|in:pix,boleto,credit_card',
            'payment_token' => 'required_if:payment_method,credit_card|string',
            'installments' => 'required_if:payment_method,credit_card|integer|min:1',
            'card_mask' => 'nullable|string',
        ]);

        foreach ($cartItems as $item) {
            $produto = Produto::find($item->id);
            if (!$produto || $produto->estoque < $item->quantity) {
                return redirect()->route('show.carrinho')->with('erro', "Estoque insuficiente para: {$item->name}");
            }
        }

        $user = Auth::user();
        $cpf = preg_replace('/\D/', '', $user->cpf ?? '');
        if (strlen($cpf) !== 11) {
            return redirect()->route('show.carrinho')->with('erro', 'Cadastre um CPF válido no seu perfil antes de finalizar a compra.');
        }

        DB::beginTransaction();
        try {
            $total = Cart::session($userId)->getTotal();
            $user = Auth::user();

            $cupomData = session('cupom');
            $discount = $cupomData['discount'] ?? 0;
            $totalComDesconto = max(0, $total - $discount);

            $order = Order::create([
                'user_id' => $userId,
                'endereco_id' => $request->input('endereco_id'),
                'total' => $totalComDesconto,
                'status' => 'processando',
                'payment_method' => $method,
                'payment_status' => 'pending',
                'coupon_id' => $cupomData['id'] ?? null,
                'coupon_code' => $cupomData['code'] ?? null,
                'discount' => $discount,
            ]);

            session()->forget('cupom');

            if ($cupomData) {
                \App\Models\Cupom::where('id', $cupomData['id'])->increment('used_count');
            }

            foreach ($cartItems as $item) {
                $produto = Produto::find($item->id);
                $produto->decrement('estoque', $item->quantity);
                OrderItem::create([
                    'order_id' => $order->id,
                    'produto_id' => $item->id,
                    'endereco_id' => $request->input('endereco_id'),
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
            }

            Cart::session($userId)->clear();

            $result = match ($method) {
                'pix' => $this->processPix($order, $user),
                'boleto' => $this->processBoleto($order, $user),
                'credit_card' => $this->processCreditCard($order, $user, $request),
            };

            DB::commit();

            Notification::notify(
                $userId,
                'order_created',
                "Pedido #{$order->id} criado",
                "Seu pedido de R$ " . number_format($total, 2, ',', '.') . " foi criado via " . match($method) { 'pix' => 'PIX', 'boleto' => 'Boleto', 'credit_card' => 'Cartão' } . ".",
                route('produtos.orders', $order->id),
                match($method) { 'pix' => 'pix', 'boleto' => 'receipt', 'credit_card' => 'credit_card' },
                match($method) { 'pix' => 'green', 'boleto' => 'blue', 'credit_card' => 'purple' },
            );

            return redirect()->route($result['redirect'], $result['params'])
                ->with('sucesso', $result['message']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro no pagamento', [
                'method' => $method,
                'error' => $e->getMessage(),
                'user' => $userId,
            ]);

            $message = $e->getMessage();
            if (str_contains($message, '4600222') || str_contains($message, 'não podem ser a mesma pessoa')) {
                $message = 'O CPF do comprador não pode ser o mesmo CPF do vendedor. Use outro CPF para finalizar a compra.';
            }

            return redirect()->route('show.carrinho')
                ->with('erro', 'Erro no pagamento: ' . $message);
        }
    }

    private function processPix(Order $order, $user): array
    {
        $cpf = preg_replace('/\D/', '', $user->cpf);

        $efiPay = app(\App\Services\EfiPayService::class);
        $cobranca = $efiPay->criarCobrancaImediata(
            cpf: $cpf,
            nomeCliente: $user->name,
            valor: $order->total,
            descricao: "Pedido #{$order->id}",
        );

        $pixCopiaCola = $cobranca['pixCopiaECola'] ?? null;

        $qrcodeBase64 = null;
        if ($pixCopiaCola) {
            try {
                $qrOptions = new \chillerlan\QRCode\QROptions(['outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG, 'scale' => 8]);
                $qrCode = new \chillerlan\QRCode\QRCode($qrOptions);
                $qrcodeBase64 = base64_encode($qrCode->render($pixCopiaCola));
            } catch (\Exception $e) {
                Log::warning('Erro ao gerar QR Code', ['error' => $e->getMessage()]);
            }
        }

        \App\Models\PixTransaction::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'txid' => $cobranca['txid'],
            'status' => $cobranca['status'] ?? 'ATIVA',
            'valor' => $order->total,
            'location' => $cobranca['loc']['location'] ?? null,
            'pix_copia_cola' => $pixCopiaCola,
            'qrcode' => $pixCopiaCola,
            'qrcode_base64' => $qrcodeBase64,
            'payload' => $cobranca,
            'expiracao' => now()->addSeconds(3600),
        ]);

        $pixTransaction = $order->fresh()->pixTransaction;

        return [
            'redirect' => 'pix.show',
            'params' => ['pixTransaction' => $pixTransaction->id],
            'message' => 'QR Code PIX gerado! Escaneie para pagar.',
        ];
    }

    private function sanitizeCustomerName(string $name): string
    {
        $name = trim(preg_replace('/\s+/', ' ', $name));
        $parts = explode(' ', $name);
        if (count($parts) < 2) {
            $name = $name . ' Cliente';
        }
        return mb_substr($name, 0, 80);
    }

    private function sanitizePhone(?string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (preg_match('/^[1-9]{2}9?\d{8}$/', $phone)) {
            return $phone;
        }
        return '11999999999';
    }

    private function processBoleto(Order $order, $user): array
    {
        $service = app(EfiCobrancasService::class);

        $items = [[
            'name' => "Pedido #{$order->id}",
            'value' => (int) (round($order->total, 2) * 100),
            'amount' => 1,
        ]];

        $cpf = preg_replace('/\D/', '', $user->cpf ?? '');
        $customer = [
            'name' => $this->sanitizeCustomerName($user->name),
            'cpf' => $cpf,
            'email' => $user->email,
            'phone_number' => $this->sanitizePhone($user->phone),
        ];

        $result = $service->gerarBoletoOneStep(
            items: $items,
            customerData: $customer,
            notificationUrl: route('webhook.cobrancas'),
            boletoConfig: ['expire_at' => now()->addDays(3)->format('Y-m-d')]
        );

        $data = $result['data'] ?? [];

        EfiCharge::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'charge_id' => $data['charge_id'] ?? null,
            'payment_method' => 'boleto',
            'total' => $order->total,
            'status' => $data['status'] ?? 'waiting',
            'boleto_url' => $data['link'] ?? null,
            'boleto_barcode' => $data['barcode'] ?? null,
            'boleto_expire_at' => now()->addDays(3)->format('Y-m-d'),
            'payload_response' => $result,
        ]);

        return [
            'redirect' => 'payment.boleto.show',
            'params' => ['order' => $order->id],
            'message' => 'Boleto gerado com sucesso!',
        ];
    }

    private function processCreditCard(Order $order, $user, Request $request): array
    {
        $service = app(EfiCobrancasService::class);
        $endereco = $order->endereco;

        $items = [[
            'name' => "Pedido #{$order->id}",
            'value' => (int) (round($order->total, 2) * 100),
            'amount' => 1,
        ]];

        $cpf = preg_replace('/\D/', '', $user->cpf ?? '');
        $customer = [
            'name' => $this->sanitizeCustomerName($user->name),
            'cpf' => $cpf,
            'email' => $user->email,
            'phone_number' => $this->sanitizePhone($user->phone),
            'birth' => $user->birth ?? '1990-01-01',
            'address' => [
                'street' => $endereco?->rua ?? '',
                'number' => $endereco?->numero ?? '',
                'neighborhood' => $endereco?->bairro ?? '',
                'zipcode' => preg_replace('/\D/', '', $endereco?->cep ?? '00000000'),
                'city' => $endereco?->cidade ?? '',
                'state' => $endereco?->uf ?? $endereco?->estado ?? '',
                'complement' => $endereco?->complemento ?? '',
            ],
        ];

        $result = $service->gerarCartaoOneStep(
            items: $items,
            customerData: $customer,
            paymentToken: $request->input('payment_token'),
            installments: (int) $request->input('installments', 1),
            notificationUrl: route('webhook.cobrancas'),
        );

        $data = $result['data'] ?? [];

        EfiCharge::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'charge_id' => $data['charge_id'] ?? null,
            'payment_method' => 'credit_card',
            'total' => $order->total,
            'status' => $data['status'] ?? 'waiting',
            'card_mask' => $request->input('card_mask'),
            'installments' => (int) $request->input('installments', 1),
            'payment_token' => $request->input('payment_token'),
            'payload_request' => $request->all(),
            'payload_response' => $result,
        ]);

        $status = $data['status'] ?? 'waiting';
        $isApproved = $status === 'approved';

        if ($isApproved) {
            $order->update(['payment_status' => 'paid', 'status' => 'pago']);
        }

        if ($refusal = $data['refusal'] ?? null) {
            $order->efiCharge->update(['refusal_reason' => $refusal['reason'] ?? null]);
        }

        return [
            'redirect' => $isApproved ? 'payment.card.success' : 'payment.card.failed',
            'params' => ['order' => $order->id],
            'message' => $isApproved ? 'Pagamento aprovado!' : 'Pagamento recusado.',
        ];
    }
}
