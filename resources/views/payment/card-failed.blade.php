@extends('user.dashboard')
@section('title', 'Pagamento Recusado')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-2xl px-4 py-12">
    <div class="animate-fade-in-up rounded-2xl border border-red-100 bg-white p-8 shadow-sm text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-100">
            <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pagamento Recusado</h1>
        <p class="text-gray-500 mb-8">Não foi possível processar o pagamento com seu cartão</p>

        @if($charge && $charge->refusal_reason)
        <div class="mb-8 rounded-xl bg-red-50 p-6">
            <p class="text-sm font-medium text-red-800 mb-1">Motivo da recusa:</p>
            <p class="text-base font-semibold text-red-900">{{ $charge->refusal_reason }}</p>
        </div>
        @else
        <div class="mb-8 rounded-xl bg-red-50 p-6">
            <p class="text-sm text-red-700">
                Verifique os dados do cartão e tente novamente. Se o problema persistir, entre em contato com seu banco.
            </p>
        </div>
        @endif

        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 mb-8">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-gray-400">info</span>
                <div class="text-sm text-gray-600 text-left">
                    <p class="font-medium text-gray-900">Possíveis causas:</p>
                    <ul class="ml-4 mt-1 list-disc space-y-1">
                        <li>Saldo ou limite insuficiente</li>
                        <li>Dados do cartão incorretos</li>
                        <li>Cartão não autorizado para compras online</li>
                        <li>Bloqueio temporário pelo banco emissor</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('produtos.orders', $order->id) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 transition">
                <span class="material-symbols-outlined">receipt</span>
                Ver detalhes do pedido
            </a>
            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50 transition">
                <span class="material-symbols-outlined">receipt</span>
                Ver meus pedidos
            </a>
        </div>
    </div>
</div>
@endsection
