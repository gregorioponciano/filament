@extends('user.dashboard')
@section('title', 'Pagamento Aprovado!')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-2xl px-4 py-12">
    <div class="animate-fade-in-scale rounded-2xl border border-green-100 bg-white p-8 shadow-sm text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pagamento Aprovado!</h1>
        <p class="text-gray-500 mb-8">Seu pagamento via cartão de crédito foi confirmado</p>

        <div class="mb-8 rounded-xl bg-green-50 p-6">
            <div class="grid gap-4 text-left sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pedido</p>
                    <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Valor</p>
                    <p class="font-semibold text-green-600">
                        R$ {{ number_format($order->total, 2, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Método</p>
                    <p class="font-semibold text-gray-900">Cartão de Crédito</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        Aprovado
                    </span>
                </div>
                @if($order->efiCharge && $order->efiCharge->card_mask)
                <div>
                    <p class="text-sm font-medium text-gray-500">Cartão</p>
                    <p class="font-semibold text-gray-900">{{ $order->efiCharge->card_mask }}</p>
                </div>
                @endif
                @if($order->efiCharge && $order->efiCharge->installments)
                <div>
                    <p class="text-sm font-medium text-gray-500">Parcelas</p>
                    <p class="font-semibold text-gray-900">{{ $order->efiCharge->installments }}x</p>
                </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('produtos.orders', $order->id) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 transition">
                <span class="material-symbols-outlined">receipt</span>
                Ver detalhes do pedido
            </a>
            <a href="{{ route('user.dashboard') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50 transition">
                <span class="material-symbols-outlined">home</span>
                Voltar ao início
            </a>
        </div>
    </div>
</div>
@endsection
