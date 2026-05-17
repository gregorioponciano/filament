<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order): void
    {
        Notification::notify(
            $order->user_id,
            'order_created',
            "Pedido #{$order->id} criado",
            "Seu pedido de R$ " . number_format($order->total, 2, ',', '.') . " foi criado com sucesso.",
            route('produtos.orders', $order->id),
            'shopping_cart',
            'blue'
        );
    }

    public function updated(Order $order): void
    {
        if ($order->wasChanged('status') && $order->status === 'cancelado') {
            Notification::notify(
                $order->user_id,
                'order_canceled',
                "Pedido #{$order->id} cancelado",
                "Seu pedido de R$ " . number_format($order->total, 2, ',', '.') . " foi cancelado.",
                route('produtos.orders', $order->id),
                'cancel',
                'red'
            );
        }

        if ($order->wasChanged('payment_status') && $order->payment_status === 'paid') {
            Notification::notify(
                $order->user_id,
                'payment_confirmed',
                "Pagamento do pedido #{$order->id} confirmado!",
                "Seu pagamento foi confirmado com sucesso.",
                route('produtos.orders', $order->id),
                'paid',
                'green'
            );
        }
    }
}
