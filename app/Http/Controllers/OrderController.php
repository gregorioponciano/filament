<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::session(Auth::id())->getContent();

        return view('produtos.orders', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $cartItems = Cart::session($userId)->getContent();

        if ($cartItems->isEmpty()) {
            return back()->with('erro', 'Carrinho vazio');
        }

        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
        ]);

        $order = Order::create([
            'user_id' => $userId,
            'endereco_id' => $request->input('endereco_id'),
            'total' => Cart::session($userId)->getTotal(),
            'status' => 'processando',
        ]);

        foreach ($cartItems as $item) {
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

        return redirect()->route('produtos.orders', $order->id)
            ->with('sucesso', 'Pedido realizado com sucesso!');
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('produtos.orders', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('produtos.my_orders', compact('orders'));
    }
}
