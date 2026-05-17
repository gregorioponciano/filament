<?php

namespace App\Http\Controllers;

use App\Models\EfiCharge;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentViewController extends Controller
{
    public function boletoShow(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $charge = EfiCharge::where('order_id', $order->id)
            ->where('payment_method', 'boleto')
            ->firstOrFail();

        return view('payment.boleto-show', compact('charge'));
    }

    public function cardSuccess(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('efiCharge', 'items');

        return view('payment.card-success', compact('order'));
    }

    public function cardFailed(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $charge = EfiCharge::where('order_id', $order->id)
            ->where('payment_method', 'credit_card')
            ->firstOrFail();

        return view('payment.card-failed', compact('order', 'charge'));
    }
}
