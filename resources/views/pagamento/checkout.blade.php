@extends('layouts.app')

@section('title', 'Finalizar Pagamento - Pedido #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Finalizar Pagamento</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Resumo do Pedido #{{ $order->id }}</h2>
        <div class="space-y-2">
            <p class="flex justify-between">
                <span class="text-gray-600">Total:</span>
                <span class="font-bold text-lg" id="orderTotal" data-total="{{ $order->total }}">
                    R$ {{ number_format($order->total, 2, ',', '.') }}
                </span>
            </p>
            @if(session('coupon_applied'))
                <p class="flex justify-between text-green-600">
                    <span>Cupom: {{ session('coupon_applied.code') }}</span>
                    <span>- R$ {{ number_format(session('coupon_applied.discount'), 2, ',', '.') }}</span>
                </p>
            @endif
            @if(session('points_redeemed'))
                <p class="flex justify-between text-blue-600">
                    <span>Pontos: -{{ session('points_redeemed.points') }} pts</span>
                    <span>- R$ {{ number_format(session('points_redeemed.discount'), 2, ',', '.') }}</span>
                </p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="font-semibold mb-3">Cupom de Desconto</h3>
        @if(session('coupon_applied'))
            <div class="flex items-center justify-between bg-green-50 p-3 rounded">
                <span class="text-green-700">Cupom <strong>{{ session('coupon_applied.code') }}</strong> aplicado!</span>
                <form action="{{ route('pagamento.coupon.remove') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Remover</button>
                </form>
            </div>
        @else
            <form action="{{ route('pagamento.coupon.apply') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="text" name="code" placeholder="Digite o código do cupom"
                    class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    required maxlength="50">
                <button type="submit"
                    class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600 transition">
                    Aplicar
                </button>
            </form>
        @endif
    </div>

    @if($pointsBalance > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="font-semibold mb-3">Pontos de Fidelidade</h3>
        <p class="text-gray-600 mb-3">Você tem <strong>{{ $pointsBalance }} pontos</strong> disponíveis.</p>
        @if(session('points_redeemed'))
            <div class="bg-blue-50 p-3 rounded">
                <span class="text-blue-700">{{ session('points_redeemed.points') }} pontos resgatados!</span>
            </div>
        @else
            <form action="{{ route('pagamento.points.redeem') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="number" name="points" placeholder="Quantos pontos usar?"
                    class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    min="100" max="{{ min($pointsBalance, 1000) }}" required>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Resgatar
                </button>
            </form>
        @endif
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Escolha a Forma de Pagamento</h3>

        @if(session('coupon_applied') || session('points_redeemed'))
            @php
                $discountTotal = $order->total;
                if (session('coupon_applied')) {
                    $discountTotal -= session('coupon_applied.discount');
                }
                if (session('points_redeemed')) {
                    $discountTotal -= session('points_redeemed.discount');
                }
                $discountTotal = max(0, $discountTotal);
            @endphp
            <div class="bg-amber-50 p-3 rounded mb-4">
                <p class="text-amber-800 font-semibold">
                    Total com descontos: R$ {{ number_format($discountTotal, 2, ',', '.') }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border-2 border-green-300 rounded-lg p-6 hover:border-green-500 transition">
                <form action="{{ route('pagamento.pix', $order) }}" method="POST">
                    @csrf
                    <div class="text-center mb-4">
                        <svg class="w-12 h-12 mx-auto text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <h4 class="font-bold text-green-700 mt-2">PIX</h4>
                        <p class="text-sm text-gray-600">Pagamento instantâneo</p>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm text-gray-600 mb-1">CPF do titular</label>
                        <input type="text" name="cpf" placeholder="000.000.000-00" required
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            value="{{ auth()->user()->cpf ?? '' }}" maxlength="14">
                    </div>
                    <button type="submit"
                        class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600 transition font-bold text-sm">
                        Gerar PIX
                    </button>
                </form>
            </div>

            <div class="border-2 border-blue-300 rounded-lg p-6 hover:border-blue-500 transition">
                <form action="{{ route('pagamento.boleto', $order) }}" method="POST">
                    @csrf
                    <div class="text-center mb-4">
                        <svg class="w-12 h-12 mx-auto text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4zM2 3v18h20V3H2zm18 16H4V5h16v14z"/>
                        </svg>
                        <h4 class="font-bold text-blue-700 mt-2">Boleto Bancário</h4>
                        <p class="text-sm text-gray-600">Vencimento em 3 dias</p>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm text-gray-600 mb-1">CPF do pagador</label>
                        <input type="text" name="cpf" placeholder="000.000.000-00" required
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ auth()->user()->cpf ?? '' }}" maxlength="14">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition font-bold text-sm">
                        Gerar Boleto
                    </button>
                </form>
            </div>

            <button type="button" onclick="showCardForm()"
                class="w-full p-6 border-2 border-amber-300 rounded-lg hover:border-amber-500 hover:bg-amber-50 transition text-center">
                <div class="text-4xl mb-2">
                    <svg class="w-12 h-12 mx-auto text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-amber-700">Cartão de Crédito</h4>
                <p class="text-sm text-gray-600">Pagamento na hora</p>
                <p class="text-xs text-amber-600 mt-1">Parcelamos em até 12x</p>
            </button>
        </div>
    </div>

    <div id="cardForm" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
        <h3 class="text-xl font-semibold mb-4">Pagamento com Cartão de Crédito</h3>

        <form id="creditCardForm" method="POST" action="{{ route('pagamento.credit_card', $order) }}">
            @csrf

            <div id="cardBrandDisplay" class="hidden mb-4 p-3 bg-gray-50 rounded text-center">
                <span id="cardBrandName" class="font-semibold text-gray-700"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Número do Cartão</label>
                <input type="text" id="cardNumber" placeholder="0000 0000 0000 0000"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    maxlength="19" required autocomplete="cc-number">
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Mês</label>
                    <input type="text" id="cardExpiryMonth" placeholder="MM"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        maxlength="2" required autocomplete="cc-exp-month">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Ano</label>
                    <input type="text" id="cardExpiryYear" placeholder="AAAA"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        maxlength="4" required autocomplete="cc-exp-year">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">CVV</label>
                    <input type="text" id="cardCvv" placeholder="123"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        maxlength="4" required autocomplete="cc-csc">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nome no Cartão</label>
                <input type="text" id="cardName" placeholder="Como está impresso no cartão"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    required autocomplete="cc-name">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">CPF/CNPJ do Titular</label>
                <input type="text" id="cardDocument" placeholder="000.000.000-00"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Parcelas</label>
                <select name="installments" id="installments"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @for($i = 1; $i <= 12; $i++)
                        @php $parcelaValue = $order->total / $i; @endphp
                        <option value="{{ $i }}">
                            {{ $i }}x de R$ {{ number_format($parcelaValue, 2, ',', '.') }}
                            @if($i === 1) (à vista) @endif
                        </option>
                    @endfor
                </select>
            </div>

            <input type="hidden" name="payment_token" id="paymentToken" value="">

            <div id="cardErrors" class="text-red-500 text-sm mb-4 hidden"></div>
            <div id="cardLoading" class="hidden mb-4 text-center">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-2 border-amber-500 border-t-transparent"></div>
                <span class="text-gray-600 ml-2">Processando cartão...</span>
            </div>

            <button type="submit" id="cardSubmitBtn"
                class="w-full bg-amber-500 text-white py-3 rounded-lg hover:bg-amber-600 transition font-bold disabled:opacity-50 disabled:cursor-not-allowed">
                Pagar R$ {{ number_format($order->total, 2, ',', '.') }}
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/@efipay/payment-token@latest/dist/payment-token-efi-umd.min.js"></script>
<script>
    const PAYEE_CODE = '{{ config('efipay.payee_code') }}';
    const ENVIRONMENT = '{{ filter_var(config('efipay.sandbox', true), FILTER_VALIDATE_BOOLEAN) ? 'sandbox' : 'production' }}';

    function showCardForm() {
        document.getElementById('cardForm').classList.remove('hidden');
        document.getElementById('cardForm').scrollIntoView({ behavior: 'smooth' });
    }

    function showError(msg) {
        const el = document.getElementById('cardErrors');
        el.textContent = msg;
        el.classList.remove('hidden');
    }

    function hideError() {
        document.getElementById('cardErrors').classList.add('hidden');
    }

    function setLoading(loading) {
        document.getElementById('cardLoading').classList.toggle('hidden', !loading);
        document.getElementById('cardSubmitBtn').disabled = loading;
    }

    document.getElementById('cardNumber').addEventListener('input', function() {
        const raw = this.value.replace(/\D/g, '').slice(0, 16);
        this.value = raw.replace(/(\d{4})(?=\d)/g, '$1 ');
        hideError();
        if (raw.length >= 6 && window.EfiPay) {
            try {
                const brand = EfiPay.CreditCard.setAccount(PAYEE_CODE).getBrand(raw);
                document.getElementById('cardBrandDisplay').classList.remove('hidden');
                document.getElementById('cardBrandName').textContent = brand.toUpperCase();
            } catch(e) {
                document.getElementById('cardBrandDisplay').classList.add('hidden');
            }
        }
    });

    document.getElementById('cardExpiryMonth').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 2);
    });
    document.getElementById('cardExpiryYear').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });
    document.getElementById('cardCvv').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });
    document.getElementById('cardDocument').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 14);
    });

    document.getElementById('creditCardForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        hideError();

        if (!PAYEE_CODE) {
            showError('Identificador de conta (payee_code) não configurado. Configure no checkout.blade.php');
            return;
        }

        const number = document.getElementById('cardNumber').value.replace(/\s/g, '');
        const month = document.getElementById('cardExpiryMonth').value;
        const year = document.getElementById('cardExpiryYear').value;
        const cvv = document.getElementById('cardCvv').value;
        const name = document.getElementById('cardName').value;
        const doc = document.getElementById('cardDocument').value;

        if (!number || number.length < 13) { showError('Número do cartão inválido'); return; }
        if (!month || month < 1 || month > 12) { showError('Mês inválido'); return; }
        if (!year || year.length !== 4) { showError('Ano inválido'); return; }
        if (!cvv || cvv.length < 3) { showError('CVV inválido'); return; }
        if (!name || name.length < 3) { showError('Nome no cartão é obrigatório'); return; }

        if (!window.EfiPay) {
            showError('Biblioteca de pagamento não carregada. Verifique sua conexão.');
            return;
        }

        let brand;
        try {
            brand = EfiPay.CreditCard.setAccount(PAYEE_CODE).getBrand(number);
        } catch(e) {
            showError('Não foi possível identificar a bandeira do cartão');
            return;
        }

        setLoading(true);

        try {
            const result = await EfiPay.CreditCard
                .setAccount(PAYEE_CODE)
                .setEnvironment(ENVIRONMENT)
                .setCreditCardData({
                    brand: brand,
                    number: number,
                    cvv: cvv,
                    expirationMonth: month,
                    expirationYear: year,
                    holderName: name,
                    holderDocument: doc || undefined,
                    reuse: false,
                })
                .getPaymentToken();

            document.getElementById('paymentToken').value = result.payment_token;

            this.submit();
        } catch (error) {
            const msg = error.error_description || error.error || 'Erro ao processar cartão';
            showError(msg);
            setLoading(false);
        }
    });
</script>
@endpush
@endsection
