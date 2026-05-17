@extends('layouts.app')

@section('title', 'Pagamento #' . $payment->id)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div id="paymentStatus" class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Status do Pagamento</h2>
            <span id="statusBadge" class="px-3 py-1 rounded-full text-sm font-semibold
                @if($payment->status === 'paid') bg-green-100 text-green-800
                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($payment->status === 'cancelled' || $payment->status === 'expired') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                @switch($payment->status)
                    @case('paid') Pago @break
                    @case('pending') Aguardando @break
                    @case('cancelled') Cancelado @break
                    @case('refunded') Reembolsado @break
                    @case('expired') Expirado @break
                    @default {{ $payment->status }}
                @endswitch
            </span>
        </div>

        <div class="border-t pt-4 space-y-2">
            <p class="flex justify-between">
                <span class="text-gray-600">Pedido:</span>
                <span>#{{ $payment->order_id }}</span>
            </p>
            <p class="flex justify-between">
                <span class="text-gray-600">Valor:</span>
                <span class="font-bold">R$ {{ number_format($payment->amount, 2, ',', '.') }}</span>
            </p>
            <p class="flex justify-between">
                <span class="text-gray-600">Método:</span>
                <span>
                    @switch($payment->payment_method)
                        @case('pix') PIX @break
                        @case('credit_card') Cartão de Crédito @break
                        @case('boleto') Boleto Bancário @break
                        @default {{ $payment->payment_method }}
                    @endswitch
                </span>
            </p>
            <p class="flex justify-between">
                <span class="text-gray-600">Criado em:</span>
                <span>{{ $payment->created_at->format('d/m/Y H:i:s') }}</span>
            </p>
            @if($payment->paid_at)
            <p class="flex justify-between text-green-600">
                <span>Pago em:</span>
                <span>{{ $payment->paid_at->format('d/m/Y H:i:s') }}</span>
            </p>
            @endif
            @if($payment->expires_at && $payment->status === 'pending')
            <p class="flex justify-between text-red-500">
                <span>Expira em:</span>
                <span id="countdownTimer" data-expires="{{ $payment->expires_at->timestamp }}">carregando...</span>
            </p>
            @endif
        </div>
    </div>

    @if($payment->payment_method === 'pix')
        <div id="pixSection" class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
            @if($payment->status === 'pending')
                <h2 class="text-xl font-semibold mb-4">Pague com PIX</h2>

                @if($payment->pix_qr_code_url)
                    <div class="mb-4">
                        <img src="{{ $payment->pix_qr_code_url }}" alt="QR Code PIX"
                            class="mx-auto w-64 h-64">
                    </div>
                @endif

                @if($payment->pix_qr_code)
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-600 mb-2">Ou copie o código PIX (copia e cola):</p>
                        <div class="flex gap-2">
                            <input type="text" value="{{ $payment->pix_qr_code }}"
                                class="flex-1 border rounded px-3 py-2 text-sm bg-white"
                                readonly id="pixCode">
                            <button onclick="copyPixCode()"
                                class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600 transition text-sm">
                                Copiar
                            </button>
                        </div>
                    </div>
                @endif

                <div id="pixWaiting" class="mt-6">
                    <div class="inline-block animate-pulse rounded-full h-3 w-3 bg-yellow-400 mr-2"></div>
                    <span class="text-sm text-gray-500">Aguardando pagamento...</span>
                    <p class="text-xs text-gray-400 mt-1">A página atualiza automaticamente a cada 10 segundos</p>
                </div>

                <div id="pixPaid" class="hidden mt-6 bg-green-50 p-6 rounded-lg">
                    <div class="text-5xl mb-3">&#10003;</div>
                    <h3 class="text-xl font-bold text-green-700">Pagamento Confirmado!</h3>
                    <p class="text-green-600 mt-1">Seu pedido #{{ $payment->order_id }} foi pago com sucesso.</p>
                </div>

                <div id="pixExpired" class="hidden mt-6 bg-red-50 p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-red-700">PIX Expirado</h3>
                    <p class="text-red-600 mt-1">O tempo para pagamento expirou.</p>
                    <a href="{{ route('pagamento.checkout', $payment->order_id) }}"
                        class="inline-block mt-3 bg-amber-500 text-white px-6 py-2 rounded hover:bg-amber-600 transition">
                        Tentar novamente
                    </a>
                </div>
            @elseif($payment->status === 'paid')
                <div class="bg-green-50 p-6 rounded-lg">
                    <div class="text-5xl mb-3 text-green-600">&#10003;</div>
                    <h2 class="text-xl font-bold text-green-700">Pagamento Confirmado!</h2>
                    <p class="text-green-600 mt-1">Seu pedido #{{ $payment->order_id }} foi pago com sucesso via PIX.</p>
                </div>
            @elseif($payment->status === 'expired')
                <div class="bg-red-50 p-6 rounded-lg">
                    <h2 class="text-xl font-bold text-red-700">PIX Expirado</h2>
                    <p class="text-red-600 mt-1">O tempo para pagamento expirou.</p>
                    <a href="{{ route('pagamento.checkout', $payment->order_id) }}"
                        class="inline-block mt-3 bg-amber-500 text-white px-6 py-2 rounded hover:bg-amber-600 transition">
                        Tentar novamente
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if($payment->payment_method === 'boleto')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            @if($payment->status === 'pending')
                <h2 class="text-xl font-semibold mb-4">Boleto Bancário</h2>
                @if($payment->boleto_url)
                    <a href="{{ $payment->boleto_url }}" target="_blank" rel="noopener noreferrer"
                        class="block w-full bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600 transition font-bold mb-4">
                        Visualizar Boleto
                    </a>
                @endif
                @if($payment->boleto_barcode)
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-600 mb-2">Código de Barras:</p>
                        <div class="flex gap-2">
                            <input type="text" value="{{ $payment->boleto_barcode }}"
                                class="flex-1 border rounded px-3 py-2 text-sm bg-white font-mono"
                                readonly id="boletoCode">
                            <button onclick="copyBoletoCode()"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition text-sm">
                                Copiar
                            </button>
                        </div>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-4">
                    Vencimento: {{ $payment->expires_at?->format('d/m/Y') ?? '3 dias úteis' }}
                </p>
            @elseif($payment->status === 'paid')
                <div class="bg-green-50 p-6 rounded-lg text-center">
                    <div class="text-5xl mb-3 text-green-600">&#10003;</div>
                    <h2 class="text-xl font-bold text-green-700">Boleto Pago!</h2>
                    <p class="text-green-600 mt-1">O boleto foi pago com sucesso.</p>
                </div>
            @endif
        </div>
    @endif

    @if($payment->payment_method === 'credit_card')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            @if($payment->status === 'paid')
                <div class="bg-green-50 p-6 rounded-lg text-center">
                    <div class="text-5xl mb-3 text-green-600">&#10003;</div>
                    <h2 class="text-xl font-bold text-green-700">Pagamento Aprovado!</h2>
                    <p class="text-green-600 mt-1">Seu pedido #{{ $payment->order_id }} foi pago com sucesso.</p>
                </div>
            @elseif($payment->status === 'pending')
                <div class="text-center py-6">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-2 border-amber-500 border-t-transparent mb-3"></div>
                    <h2 class="text-xl font-bold text-amber-700">Pagamento em Análise</h2>
                    <p class="text-gray-600 mt-1">O status será atualizado assim que a operadora confirmar.</p>
                </div>
            @endif
            @if($payment->credit_card_details)
                <div class="border-t pt-4 mt-4 space-y-2">
                    @if(isset($payment->credit_card_details['last_digits']))
                    <p class="flex justify-between">
                        <span class="text-gray-600">Cartão:</span>
                        <span>**** **** **** {{ $payment->credit_card_details['last_digits'] }}</span>
                    </p>
                    @endif
                    @if(isset($payment->credit_card_details['brand']))
                    <p class="flex justify-between">
                        <span class="text-gray-600">Bandeira:</span>
                        <span class="font-semibold">{{ $payment->credit_card_details['brand'] }}</span>
                    </p>
                    @endif
                    @if(isset($payment->credit_card_details['installments']))
                    <p class="flex justify-between">
                        <span class="text-gray-600">Parcelas:</span>
                        <span>{{ $payment->credit_card_details['installments'] }}x</span>
                    </p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="flex gap-4">
        <a href="{{ route('orders.index') }}"
            class="flex-1 text-center bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition">
            Meus Pedidos
        </a>
        @if($payment->status === 'pending')
            <a href="{{ route('pagamento.checkout', $payment->order_id) }}"
                class="flex-1 text-center bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition">
                Tentar outro método
            </a>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function copyPixCode() {
        const input = document.getElementById('pixCode');
        if (!input) return;
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            showToast('Código PIX copiado!', 'sucesso');
        }).catch(() => {
            input.select();
            document.execCommand('copy');
            showToast('Código PIX copiado!', 'sucesso');
        });
    }

    function copyBoletoCode() {
        const input = document.getElementById('boletoCode');
        if (!input) return;
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            showToast('Código de barras copiado!', 'sucesso');
        }).catch(() => {
            input.select();
            document.execCommand('copy');
            showToast('Código de barras copiado!', 'sucesso');
        });
    }

    function updateCountdown() {
        const el = document.getElementById('countdownTimer');
        if (!el) return;
        const expiresAt = parseInt(el.dataset.expires);
        if (!expiresAt) return;
        const now = Math.floor(Date.now() / 1000);
        const diff = expiresAt - now;
        if (diff <= 0) {
            el.textContent = 'expirado';
            el.classList.add('text-red-600', 'font-bold');
            return;
        }
        const h = String(Math.floor(diff / 3600)).padStart(2, '0');
        const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
        const s = String(diff % 60).padStart(2, '0');
        el.textContent = h + 'h ' + m + 'm ' + s + 's';
    }

    let statusCheckInterval = null;
    let redirectTimeout = null;

    function getStatusInfo(status) {
        const map = {
            paid: { text: 'Pago', class: 'bg-green-100 text-green-800' },
            pending: { text: 'Aguardando', class: 'bg-yellow-100 text-yellow-800' },
            cancelled: { text: 'Cancelado', class: 'bg-red-100 text-red-800' },
            expired: { text: 'Expirado', class: 'bg-red-100 text-red-800' },
            refunded: { text: 'Reembolsado', class: 'bg-gray-100 text-gray-800' },
        };
        return map[status] || { text: status, class: 'bg-gray-100 text-gray-800' };
    }

    function updatePixUI(status) {
        const pixWaiting = document.getElementById('pixWaiting');
        const pixPaid = document.getElementById('pixPaid');
        const pixExpired = document.getElementById('pixExpired');

        if (status === 'paid') {
            if (pixWaiting) pixWaiting.classList.add('hidden');
            if (pixPaid) pixPaid.classList.remove('hidden');
            if (pixExpired) pixExpired.classList.add('hidden');
            // Para o polling e redireciona após 3s
            stopPolling();
            if (!redirectTimeout) {
                redirectTimeout = setTimeout(() => {
                    window.location.href = '{{ route("orders.index") }}';
                }, 3000);
            }
        } else if (status === 'expired') {
            if (pixWaiting) pixWaiting.classList.add('hidden');
            if (pixPaid) pixPaid.classList.add('hidden');
            if (pixExpired) pixExpired.classList.remove('hidden');
            stopPolling();
        }
    }

    function stopPolling() {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval);
            statusCheckInterval = null;
        }
    }

    async function checkPaymentStatus() {
        const badge = document.getElementById('statusBadge');
        if (!badge) return;

        try {
            const res = await fetch('{{ route("pagamento.show", $payment) }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            const status = data.status;
            const info = getStatusInfo(status);

            badge.textContent = info.text;
            badge.className = 'px-3 py-1 rounded-full text-sm font-semibold ' + info.class;

            updatePixUI(status);
        } catch(e) {
            // silent
        }
    }

    // Polling de status via Webhook ou consulta direta à API
    async function checkPaymentStatusDirect() {
        const badge = document.getElementById('statusBadge');
        if (!badge) return;

        try {
            const res = await fetch('{{ route("pagamento.show", $payment) }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            const status = data.status;

            if (status !== '{{ $payment->status }}') {
                const info = getStatusInfo(status);
                badge.textContent = info.text;
                badge.className = 'px-3 py-1 rounded-full text-sm font-semibold ' + info.class;
                updatePixUI(status);
                if (status === 'paid') {
                    showToast('Pagamento confirmado com sucesso!', 'sucesso');
                }
            }
        } catch(e) {}
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    @if(in_array($payment->payment_method, ['pix', 'boleto']) && $payment->status === 'pending')
        statusCheckInterval = setInterval(checkPaymentStatus, 10000);
    @endif
</script>
@endpush
@endsection
