@extends('user.dashboard')
@section('title', 'Detalhes do Pedido')

@section('dashboard')

@include('user.dashboard-content')

<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="mb-4 flex flex-row justify-between items-center rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <a href="{{ url('/user') }}"
           class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl group-hover:-translate-x-0.5 transition">arrow_circle_left</span>
            Voltar
        </a>

        <a href="{{ route('orders.index') }}"
           class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
            Meus pedidos
        </a>

        <span class="rounded-full bg-blue-50 px-4 py-1.5 text-sm font-semibold text-blue-600">
            Pedido #{{ $order->id }}
        </span>
    </div>

        <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Status do pedido</p>
                @php
                    $statusColors = [
                        'pago' => 'text-green-600',
                        'concluido' => 'text-green-600',
                        'processando' => 'text-blue-600',
                        'pendente' => 'text-yellow-600',
                        'cancelado' => 'text-red-600',
                    ];
                    $statusLabels = [
                        'pago' => 'Pago',
                        'concluido' => 'Concluído',
                        'processando' => 'Processando',
                        'pendente' => 'Pendente',
                        'cancelado' => 'Cancelado',
                    ];
                @endphp
                <p class="mt-1 text-lg font-bold {{ $statusColors[$order->status] ?? 'text-gray-600' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Pagamento</p>
                @php
                    $payStatusColors = [
                        'paid' => 'text-green-600',
                        'pending' => 'text-yellow-600',
                        'failed' => 'text-red-600',
                        'canceled' => 'text-gray-500',
                    ];
                    $payStatusLabels = [
                        'paid' => 'Pago',
                        'pending' => 'Pendente',
                        'failed' => 'Recusado',
                        'canceled' => 'Cancelado',
                    ];
                @endphp
                <p class="mt-1 text-lg font-semibold {{ $payStatusColors[$order->payment_status] ?? 'text-yellow-600' }}">
                    <span class="flex items-center gap-2">
                        @if($order->payment_method === 'pix')
                            <svg class="h-5 w-5" viewBox="0 0 32 32" fill="none"><rect width="32" height="32" rx="8" fill="#32BCAD"/><path d="M10 20L16 12L22 20H10Z" fill="white"/></svg>
                            PIX
                        @elseif($order->payment_method === 'boleto')
                            <span class="material-symbols-outlined text-lg">receipt_long</span>
                            Boleto
                        @elseif($order->payment_method === 'credit_card')
                            <span class="material-symbols-outlined text-lg">credit_card</span>
                            Cartão
                        @endif
                        &middot; {{ $payStatusLabels[$order->payment_status] ?? 'Pendente' }}
                    </span>
                </p>
            @if($order->efiCharge && $order->efiCharge->card_mask)
                <p class="text-xs text-gray-400 mt-1">{{ $order->efiCharge->card_mask }} · {{ $order->efiCharge->installments }}x</p>
            @endif
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Data do pedido</p>
            <p class="mt-1 text-lg font-semibold text-gray-700">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    @if($order->payment_status !== 'paid')
        @if($order->payment_method === 'pix' && $order->pixTransaction)
            @php
                $pixExpirada = $order->pixTransaction->expiracao && now()->greaterThan($order->pixTransaction->expiracao);
            @endphp
            @if($pixExpirada)
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-red-600">timer_off</span>
                            <div>
                                <p class="font-semibold text-red-800">Cobrança PIX expirada</p>
                                <p class="text-sm text-red-600">O QR Code não é mais válido. Faça um novo pedido.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="mb-6 rounded-2xl border border-yellow-200 bg-yellow-50 p-5 animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-yellow-600">hourglass_top</span>
                        <div>
                            <p class="font-semibold text-yellow-800">Aguardando pagamento PIX</p>
                            <p class="text-sm text-yellow-600">Escaneie o QR Code ou copie o código para pagar</p>
                        </div>
                    </div>
                    <a href="{{ route('pix.show', $order->pixTransaction->id) }}"
                       class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
                        Ver QR Code
                    </a>
                </div>
            </div>
            @endif
        @elseif($order->payment_method === 'boleto' && $order->efiCharge)
            @php
                $boletoVencido = $order->efiCharge->boleto_expire_at && now()->greaterThan(\Carbon\Carbon::parse($order->efiCharge->boleto_expire_at));
            @endphp
            @if($boletoVencido)
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-red-600">calendar_month</span>
                            <div>
                                <p class="font-semibold text-red-800">Boleto vencido</p>
                                <p class="text-sm text-red-600">O boleto venceu em {{ \Carbon\Carbon::parse($order->efiCharge->boleto_expire_at)->format('d/m/Y') }}. Gere um novo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-5 animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-blue-600">receipt_long</span>
                        <div>
                            <p class="font-semibold text-blue-800">Boleto gerado</p>
                            <p class="text-sm text-blue-600">Vencimento: {{ \Carbon\Carbon::parse($order->efiCharge->boleto_expire_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('payment.boleto.show', $order->id) }}"
                       class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Ver Boleto
                    </a>
                </div>
            </div>
            @endif
        @elseif($order->payment_method === 'credit_card' && $order->efiCharge && $order->efiCharge->status !== 'approved')
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-600">credit_card_off</span>
                        <div>
                            <p class="font-semibold text-red-800">Pagamento recusado</p>
                            <p class="text-sm text-red-600">{{ $order->efiCharge->refusal_reason ?? 'Tente novamente com outro cartão' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('payment.card.failed', $order->id) }}"
                       class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                        Ver detalhes
                    </a>
                </div>
            </div>
        @endif
    @endif

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

    <div class="mb-6 flex items-center justify-between rounded-2xl border border-blue-200 bg-blue-50 p-5">
        <span class="text-lg font-semibold text-gray-700">Total</span>
        <span class="text-2xl font-bold text-blue-700">
            R$ {{ number_format($order->total, 2, ',', '.') }}
        </span>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-end">
        @if(($order->status === 'pendente' || $order->status === 'processando') && $order->payment_status !== 'paid')
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

        @if($order->payment_method === 'pix' && $order->payment_status !== 'paid' && $order->pixTransaction)
            @php
                $pixExpirada = $order->pixTransaction->expiracao && now()->greaterThan($order->pixTransaction->expiracao);
            @endphp
            @if(!$pixExpirada)
            <a href="{{ route('pix.show', $order->pixTransaction->id) }}"
               class="flex items-center justify-center gap-2 rounded-xl border border-green-200 bg-green-50 px-5 py-2.5 text-sm font-semibold text-green-700 hover:bg-green-100 transition">
                <svg class="h-5 w-5" viewBox="0 0 32 32" fill="none"><rect width="32" height="32" rx="8" fill="#32BCAD"/><path d="M10 20L16 12L22 20H10Z" fill="white"/></svg>
                Pagar com PIX
            </a>
            @endif
        @elseif($order->payment_method === 'boleto' && $order->payment_status !== 'paid' && $order->efiCharge)
            @php
                $boletoVencido = $order->efiCharge->boleto_expire_at && now()->greaterThan(\Carbon\Carbon::parse($order->efiCharge->boleto_expire_at));
            @endphp
            @if(!$boletoVencido)
            <a href="{{ route('payment.boleto.show', $order->id) }}"
               class="flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-5 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 transition">
                <span class="material-symbols-outlined text-base">receipt_long</span>
                Ver Boleto
            </a>
            @endif
        @elseif($order->payment_method === 'credit_card' && $order->payment_status !== 'paid')
            <a href="{{ route('payment.card.failed', $order->id) }}"
               class="flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-100 transition">
                <span class="material-symbols-outlined text-base">credit_card</span>
                Tentar novamente
            </a>
        @endif

        <a href="{{ route('orders.index') }}"
           class="flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Voltar para pedidos
        </a>
    </div>

</div>

@endsection
