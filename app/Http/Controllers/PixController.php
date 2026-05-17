<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PixTransaction;
use App\Models\Produto;
use App\Services\EfiPayService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PixController extends Controller
{
    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $cartItems = Cart::session($userId)->getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('show.carrinho')->with('erro', 'Carrinho vazio');
        }

        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
        ]);

        foreach ($cartItems as $item) {
            $produto = Produto::find($item->id);
            if (!$produto || $produto->estoque < $item->quantity) {
                return redirect()->route('show.carrinho')->with('erro', "Estoque insuficiente para: {$item->name}");
            }
        }

        $cpf = preg_replace('/\D/', '', Auth::user()->cpf ?? '');
        if (strlen($cpf) !== 11) {
            return redirect()->route('show.carrinho')->with('erro', 'Cadastre um CPF válido no seu perfil antes de finalizar a compra.');
        }

        DB::beginTransaction();
        try {
            $total = Cart::session($userId)->getTotal();

            $order = Order::create([
                'user_id' => $userId,
                'endereco_id' => $request->input('endereco_id'),
                'total' => $total,
                'status' => 'processando',
                'payment_method' => 'pix',
                'payment_status' => 'pending',
            ]);

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

            $efiPay = app(EfiPayService::class);
            $user = Auth::user();

            $cpf = preg_replace('/\D/', '', $user->cpf ?? '');
            $cobranca = $efiPay->criarCobrancaImediata(
                cpf: $cpf,
                nomeCliente: $user->name,
                valor: $total,
                descricao: "Pedido #{$order->id}",
            );

            $pixCopiaCola = $cobranca['pixCopiaECola'] ?? null;

            $qrcodeBase64 = null;
            if ($pixCopiaCola) {
                try {
                    $qrOptions = new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'scale' => 8]);
                    $qrCode = new QRCode($qrOptions);
                    $qrcodeBase64 = base64_encode($qrCode->render($pixCopiaCola));
                } catch (\Exception $e) {
                    Log::warning('Erro ao gerar QR Code', ['error' => $e->getMessage()]);
                }
            }

            $pixTransaction = PixTransaction::create([
                'order_id' => $order->id,
                'user_id' => $userId,
                'txid' => $cobranca['txid'],
                'status' => $cobranca['status'] ?? 'ATIVA',
                'valor' => $total,
                'location' => $cobranca['loc']['location'] ?? null,
                'pix_copia_cola' => $pixCopiaCola,
                'qrcode' => $pixCopiaCola,
                'qrcode_base64' => $qrcodeBase64,
                'payload' => $cobranca,
                'expiracao' => now()->addSeconds(3600),
            ]);

            DB::commit();

            return redirect()->route('pix.show', $pixTransaction->id)
                ->with('sucesso', 'Pedido criado! Aguardando pagamento PIX.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar pagamento PIX', [
                'error' => $e->getMessage(),
                'user' => $userId,
            ]);
            return redirect()->route('show.carrinho')
                ->with('erro', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    public function show(PixTransaction $pixTransaction)
    {
        if ($pixTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $pixTransaction->load('order.items');

        return view('produtos.pix-payment', compact('pixTransaction'));
    }

    public function status(PixTransaction $pixTransaction)
    {
        if ($pixTransaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $efiPay = app(EfiPayService::class);
            $cobranca = $efiPay->consultarCobranca($pixTransaction->txid);

            $statusAtual = $cobranca['status'] ?? $pixTransaction->status;

            if ($statusAtual !== $pixTransaction->status) {
                $pixTransaction->update([
                    'status' => $statusAtual,
                    'payload' => $cobranca,
                ]);

                if ($statusAtual === 'CONCLUIDA') {
                    $pixTransaction->update(['pago_em' => now()]);
                    $pixTransaction->order->update(['payment_status' => 'paid', 'status' => 'pago']);
                }
            }

            return response()->json([
                'status' => $statusAtual,
                'pago' => $statusAtual === 'CONCLUIDA',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $pixTransaction->status,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sucesso(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items', 'pixTransaction');
        return view('produtos.pix-success', compact('order'));
    }
}
