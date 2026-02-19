@extends('user.dashboard')
@section('title', 'Detalhes do Pedido')

@section('dashboard')

@include('user.dashboard-content')

<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Topo / Voltar --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ url('/user') }}"
               class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl group-hover:-translate-x-0.5 transition">
                    arrow_circle_left
                </span>
                Voltar
            </a>

            <a href="{{ route('orders.index') }}"
               class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
                Meus pedidos
            </a>
        </div>

        <span class="rounded-full bg-blue-50 px-4 py-1.5 text-sm font-semibold text-blue-600">
            Pedido #{{ $order->id }}
        </span>
    </div>

    {{-- Status / Data --}}
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Status do pedido</p>
            <p class="mt-1 text-lg font-bold 
                {{ $order->status === 'cancelado' ? 'text-red-600' : 'text-blue-600' }}">
                {{ ucfirst($order->status) }}
            </p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Data do pedido</p>
            <p class="mt-1 text-lg font-semibold text-gray-700">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- Endereço --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <h3 class="mb-2 flex items-center gap-2 text-lg font-bold text-gray-800">
            <span class="material-symbols-outlined text-blue-500">location_on</span>
            Endereço de Entrega
        </h3>
        <p class="text-gray-700 leading-relaxed">
            {{ $order->rua }}, {{ $order->numero }} <br>
            {{ $order->bairro }} - {{ $order->cidade }}/{{ $order->estado }}
        </p>
    </div>

    {{-- Itens --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <h3 class="mb-4 text-lg font-bold text-gray-800">Itens do Pedido</h3>

        <div class="space-y-3">
            @foreach ($order->items as $item)
                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                        <p class="text-sm text-gray-500">Quantidade: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-gray-700">
                        R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Total --}}
    <div class="mb-6 flex items-center justify-between rounded-2xl border border-blue-200 bg-blue-50 p-5">
        <span class="text-lg font-semibold text-gray-700">Total</span>
        <span class="text-2xl font-bold text-blue-700">
            R$ {{ number_format($order->total, 2, ',', '.') }}
        </span>
    </div>

    {{-- Ações --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-end">

        {{-- Cancelar Pedido --}}
        @if($order->status === 'pendente' || $order->status === 'processando')
            <form action="{{ route('orders.cancelar', $order->id) }}" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?')">
                @csrf
                @method('PUT')

                <button type="submit"
                        class="flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100 transition">
                    <span class="material-symbols-outlined text-base">cancel</span>
                    Cancelar Pedido
                </button>
            </form>
        @endif

        {{-- Voltar --}}
        <a href="{{ route('orders.index') }}"
           class="flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Voltar para pedidos
        </a>
    </div>

</div>

@endsection
