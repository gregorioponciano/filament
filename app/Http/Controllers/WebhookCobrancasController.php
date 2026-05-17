<?php

namespace App\Http\Controllers;

use App\Models\EfiCharge;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookCobrancasController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Webhook Cobrancas recebido', ['payload' => $request->all()]);

        try {
            $chargeId = $request->input('charge_id');
            $status = $request->input('status');
            $notificationData = $request->all();

            if (!$chargeId || !$status) {
                Log::warning('Webhook Cobrancas sem dados suficientes', ['payload' => $request->all()]);
                return response('OK', 200);
            }

            $charge = EfiCharge::where('charge_id', $chargeId)->first();

            if (!$charge) {
                Log::warning('Cobranca nao encontrada no webhook', ['charge_id' => $chargeId]);
                return response('OK', 200);
            }

            $charge->update([
                'status' => $status,
                'notification_data' => $notificationData,
            ]);

            $order = $charge->order;
            if ($order) {
                if ($status === 'paid' || $status === 'completed' || $status === 'approved') {
                    $order->update(['payment_status' => 'paid', 'status' => 'pago']);
                    $charge->update(['paid_at' => now()]);

                    Notification::notify(
                        $charge->user_id,
                        'payment_confirmed',
                        "Pagamento do pedido #{$order->id} confirmado!",
                        "Seu pagamento via " . ($charge->payment_method === 'boleto' ? 'Boleto' : 'Cartão') . " foi confirmado.",
                        route('produtos.orders', $order->id),
                        'paid',
                        'green'
                    );
                }

                if ($status === 'unpaid' || $status === 'refunded') {
                    $order->update(['payment_status' => 'failed']);
                }

                if ($status === 'canceled') {
                    $order->update(['payment_status' => 'canceled']);
                }
            }

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Erro webhook cobrancas', ['error' => $e->getMessage()]);
            return response('OK', 200);
        }
    }
}
