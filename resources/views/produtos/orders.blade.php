@extends('user.dashboard')
@section('title', 'Detalhes do Pedido')

@section('dashboard')

@include('user.dashboard-content')
<div class="max-w-4xl mx-auto p-6">
     <div class="flex justify-between items-center mb-4 p-4 rounded-xl border border-gray-200 bg-gray-50 shadow-sm">
         <a href="{{ url('/user') }}" class="flex items-center text-blue-300  hover:text-blue-400 transition ">
                    <span style="font-size: 32px;" class="material-symbols-outlined">
                        arrow_circle_left
                    </span>
                </a>
                <a href="{{ route('orders.index') }}" class="text-blue-300 hover:text-blue-400 transition">Pedidos</a>
     </div>

    <div class="mb-6 flex justify-between items-center p-6 rounded-xl border border-gray-200 bg-gray-50 shadow-sm">
        <p class="text-lg text-gray-700">Status: <span class="font-semibold text-blue-600">{{ $order->status }}</span></p>
        <p>Data: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

   
        <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 p-5 shadow-sm">
            <h3 class="mb-2 text-lg font-bold text-gray-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-500">location_on</span>
                Endereço de Entrega
            </h3>
            <p class="text-gray-700">
                {{ $order->rua }}, {{ $order->numero }}<br>
                {{ $order->bairro }} - {{ $order->cidade }}/{{ $order->estado }}
            </p>
        </div>
 

    <div class="mt-4">
        @foreach ($order->items as $item)
            <div class="flex justify-between border-b py-2">
                <p>{{ $item->name }} (x{{ $item->quantity }})</p>
                <p>R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-4 font-bold text-xl">
        Total: R$ {{ number_format($order->total, 2, ',', '.') }}
    </div>
</div>

@endsection
