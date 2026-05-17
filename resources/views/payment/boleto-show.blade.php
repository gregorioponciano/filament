@extends('user.dashboard')
@section('title', 'Boleto Gerado')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-3xl px-4 py-8">
    <div class="animate-fade-in-up rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('orders.index') }}"
               class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">arrow_circle_left</span>
                Voltar
            </a>
        </div>

        <div class="text-center mb-8">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                <span class="material-symbols-outlined text-3xl text-blue-600">receipt_long</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Boleto Gerado!</h1>
            <p class="mt-1 text-sm text-gray-500">Seu boleto foi gerado com sucesso. Pague até o vencimento.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500">Pedido</p>
                <p class="text-xl font-bold text-gray-900">#{{ $charge->order_id }}</p>
            </div>
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500">Valor</p>
                <p class="text-xl font-bold text-gray-900">
                    R$ {{ number_format($charge->total, 2, ',', '.') }}
                </p>
            </div>
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500">Vencimento</p>
                <p class="text-lg font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($charge->boleto_expire_at)->format('d/m/Y') }}
                </p>
            </div>
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500">Status</p>
                @php
                    $boletoVencido = $charge->boleto_expire_at && now()->greaterThan(\Carbon\Carbon::parse($charge->boleto_expire_at));
                @endphp
                @if($boletoVencido)
                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    Vencido
                </span>
                @elseif($charge->isPaid())
                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    Pago
                </span>
                @else
                <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                    <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                    Aguardando pagamento
                </span>
                @endif
            </div>
        </div>

        @if($charge->boleto_url)
            <div class="mb-6 rounded-xl border-2 border-dashed border-blue-200 bg-blue-50 p-6 text-center">
                <span class="material-symbols-outlined text-4xl text-blue-600 mb-2">description</span>
                <h3 class="text-lg font-semibold text-blue-900 mb-1">Download do Boleto</h3>
                <p class="text-sm text-blue-700 mb-4">Clique no botão abaixo para visualizar e imprimir seu boleto.</p>
                <a href="{{ $charge->boleto_url }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                    <span class="material-symbols-outlined">download</span>
                    Baixar Boleto
                </a>
            </div>
        @endif

        @if($charge->boleto_barcode)
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500 mb-2">Linha Digitável</p>
                <div class="relative">
                    <input type="text" value="{{ $charge->boleto_barcode }}" readonly
                           class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button onclick="copiarCodigo()"
                            class="absolute right-1 top-1/2 -translate-y-1/2 rounded-md bg-gray-700 px-3 py-1.5 text-xs font-medium text-white hover:bg-gray-800 transition">
                        Copiar
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">Copie o código e pague pelo internet banking.</p>
            </div>
        @endif

        <div class="mt-8 rounded-xl border border-gray-100 bg-gray-50 p-4">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-gray-400">info</span>
                <div class="text-sm text-gray-600">
                    <p class="font-medium text-gray-900">Instruções:</p>
                    <ol class="ml-4 mt-1 list-decimal space-y-1">
                        <li>Faça o download do boleto ou copie a linha digitável</li>
                        <li>Pague em qualquer banco, casa lotérica ou internet banking</li>
                        <li>O pagamento pode levar até 3 dias úteis para confirmar</li>
                        <li>Após a confirmação, você receberá uma notificação</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('produtos.orders', $charge->order_id) }}"
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

<script>
function copiarCodigo() {
    const input = document.querySelector('input[value="{{ $charge->boleto_barcode }}"]');
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = event.currentTarget;
        btn.textContent = 'Copiado!';
        btn.classList.add('bg-green-600');
        setTimeout(() => {
            btn.textContent = 'Copiar';
            btn.classList.remove('bg-green-600');
        }, 2000);
    });
}
</script>
@endsection
