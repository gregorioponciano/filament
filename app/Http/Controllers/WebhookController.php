<?php

namespace App\Http\Controllers;

use App\Models\PixTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Webhook PIX recebido', ['payload' => $request->all()]);

        try {
            $pixData = $request->input('pix', []);

            foreach ($pixData as $pix) {
                $txid = $pix['txid'] ?? null;
                $endToEndId = $pix['endToEndId'] ?? null;

                if (!$txid) {
                    continue;
                }

                $transaction = PixTransaction::where('txid', $txid)->first();

                if (!$transaction) {
                    Log::warning('Transação PIX não encontrada', ['txid' => $txid]);
                    continue;
                }

                $transaction->update([
                    'status' => 'CONCLUIDA',
                    'end_to_end_id' => $endToEndId,
                    'pago_em' => now(),
                    'webhook_received' => $request->all(),
                ]);

                $order = $transaction->order;
                if ($order && $order->payment_status !== 'paid') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'pago',
                    ]);
                }

                Log::info('PIX confirmado via webhook', [
                    'txid' => $txid,
                    'order_id' => $transaction->order_id,
                ]);
            }

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook PIX', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);
            return response('OK', 200);
        }
    }
}
