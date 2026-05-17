<?php

namespace App\Observers;

use App\Models\EfiCharge;
use App\Models\Notification;

class EfiChargeObserver
{
    public function created(EfiCharge $charge): void
    {
        $methodLabel = match ($charge->payment_method) {
            'boleto' => 'Boleto',
            'credit_card' => 'Cartão de Crédito',
            default => $charge->payment_method,
        };

        Notification::notify(
            $charge->user_id,
            'charge_created',
            "Cobrança gerada via {$methodLabel}",
            "Sua cobrança no valor de R$ " . number_format($charge->total, 2, ',', '.') . " foi gerada.",
            $charge->payment_method === 'boleto'
                ? route('payment.boleto.show', $charge->order_id)
                : route('produtos.orders', $charge->order_id),
            match ($charge->payment_method) {
                'boleto' => 'receipt_long',
                'credit_card' => 'credit_card',
                default => 'notifications',
            },
            match ($charge->payment_method) {
                'boleto' => 'blue',
                'credit_card' => 'purple',
                default => 'blue',
            },
        );
    }

    public function updated(EfiCharge $charge): void
    {
        $wasPaid = in_array($charge->getOriginal('status'), ['paid', 'approved', 'completed']);
        $isPaid = in_array($charge->status, ['paid', 'approved', 'completed']);

        if (!$wasPaid && $isPaid) {
            $methodLabel = match ($charge->payment_method) {
                'boleto' => 'Boleto',
                'credit_card' => 'Cartão de Crédito',
                default => $charge->payment_method,
            };

            Notification::notify(
                $charge->user_id,
                'payment_confirmed',
                "Pagamento via {$methodLabel} confirmado!",
                "Seu pagamento de R$ " . number_format($charge->total, 2, ',', '.') . " foi confirmado.",
                route('produtos.orders', $charge->order_id),
                'paid',
                'green'
            );
        }

        if ($charge->wasChanged('status') && $charge->status === 'canceled') {
            Notification::notify(
                $charge->user_id,
                'charge_canceled',
                "Cobrança cancelada",
                "Sua cobrança de R$ " . number_format($charge->total, 2, ',', '.') . " foi cancelada.",
                route('produtos.orders', $charge->order_id),
                'cancel',
                'red'
            );
        }
    }
}
