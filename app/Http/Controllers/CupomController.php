<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CupomController extends Controller
{
    public function apply(Request $request): JsonResponse
    {
        $request->validate(['code' => 'required|string|max:50']);

        $cupom = Cupom::where('code', $request->code)->first();

        if (!$cupom) {
            return response()->json(['success' => false, 'message' => 'Cupom não encontrado.'], 404);
        }

        if (!$cupom->isValid()) {
            return response()->json(['success' => false, 'message' => 'Cupom expirado ou fora de validade.'], 400);
        }

        $userId = Auth::id();
        $cartItems = Cart::session($userId)->getContent();
        $subtotal = Cart::session($userId)->getTotal();

        if ($cupom->product_id) {
            $productInCart = $cartItems->firstWhere('id', $cupom->product_id);
            if (!$productInCart) {
                return response()->json(['success' => false, 'message' => 'Cupom válido apenas para um produto específico que não está no carrinho.'], 400);
            }
            $discount = $cupom->calculateDiscount($subtotal, $productInCart->price * $productInCart->quantity);
        } else {
            $discount = $cupom->calculateDiscount($subtotal);
        }

        if ($discount <= 0) {
            return response()->json(['success' => false, 'message' => 'Cupom não se aplica ao valor mínimo.'], 400);
        }

        $totalComDesconto = max(0, $subtotal - $discount);

        session([
            'cupom' => [
                'id' => $cupom->id,
                'code' => $cupom->code,
                'discount' => $discount,
                'type' => $cupom->type,
                'value' => $cupom->value,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => "Cupom aplicado! Desconto de R$ " . number_format($discount, 2, ',', '.'),
            'discount' => $discount,
            'total' => $totalComDesconto,
            'cupom_code' => $cupom->code,
        ]);
    }

    public function remove(): JsonResponse
    {
        session()->forget('cupom');
        $userId = Auth::id();
        $total = Cart::session($userId)->getTotal();

        return response()->json([
            'success' => true,
            'message' => 'Cupom removido.',
            'total' => $total,
        ]);
    }
}
