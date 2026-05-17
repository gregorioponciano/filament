@extends('user.dashboard')
@section('title', 'Pagar com PIX')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-3xl px-4 py-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('orders.index') }}"
               class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">arrow_circle_left</span>
                Voltar
            </a>
        </div>

        <div class="text-center mb-8">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                <span class="material-symbols-outlined text-3xl text-green-600">pix</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Pagamento via PIX</h1>
            <p class="mt-1 text-sm text-gray-500">Escaneie o QR Code abaixo para pagar</p>
        </div>

        <div class="grid gap-8 md:grid-cols-2">
            <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 p-8">
                <div id="qrcode-container" class="h-64 w-64 flex items-center justify-center">
                    <div id="qrcode-loading" class="animate-pulse text-gray-400 text-center">
                        <span class="material-symbols-outlined text-6xl">qr_code_scanner</span>
                        <p class="mt-2 text-sm">Carregando QR Code...</p>
                    </div>
                    <div id="qrcode-render" class="hidden"></div>
                </div>
            </div>

            <div class="flex flex-col justify-center space-y-4">
                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-sm font-medium text-gray-500">Valor</p>
                    <p class="text-3xl font-bold text-gray-900">
                        R$ {{ number_format($pixTransaction->valor, 2, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p id="pix-status" class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                        <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                        Aguardando pagamento
                    </p>
                </div>

                <div class="rounded-xl bg-blue-50 p-4">
                    <p class="text-sm font-medium text-blue-800 mb-2">Código PIX Copia e Cola</p>
                    @if($pixTransaction->pix_copia_cola)
                        <div class="relative">
                            <input type="text"
                                   id="pix-copia-cola"
                                   value="{{ $pixTransaction->pix_copia_cola }}"
                                   readonly
                                   class="w-full rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button onclick="copiarPix()"
                                    class="absolute right-1 top-1/2 -translate-y-1/2 rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition">
                                Copiar
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-blue-600">Copie o código e pague pelo app do seu banco</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-gray-100 bg-gray-50 p-4">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-gray-400">info</span>
                <div class="text-sm text-gray-600">
                    <p class="font-medium text-gray-900">Instruções:</p>
                    <ol class="ml-4 mt-1 list-decimal space-y-1">
                        <li>Abra o app do seu banco</li>
                        <li>Escolha a opção PIX</li>
                        <li>Escaneie o QR Code ou cole o código</li>
                        <li>Confirme o pagamento</li>
                    </ol>
                    <p class="mt-2 text-xs text-gray-500">O QR Code expira em 60 minutos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
const txid = '{{ $pixTransaction->txid }}';
const statusUrl = '{{ route("pix.status", $pixTransaction->id) }}';
const successUrl = '{{ route("pix.sucesso", $pixTransaction->order_id) }}';
const pixCopiaCola = '{{ $pixTransaction->pix_copia_cola }}';

document.addEventListener('DOMContentLoaded', function() {
    if (pixCopiaCola) {
        document.getElementById('qrcode-loading').classList.add('hidden');
        const container = document.getElementById('qrcode-render');
        container.classList.remove('hidden');
        new QRCode(container, {
            text: pixCopiaCola,
            width: 256,
            height: 256,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    }
});

function copiarPix() {
    const input = document.getElementById('pix-copia-cola');
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

function verificarStatus() {
    fetch(statusUrl)
        .then(r => r.json())
        .then(data => {
            const statusEl = document.getElementById('pix-status');
            if (data.pago) {
                statusEl.className = 'inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800';
                statusEl.innerHTML = '<span class="h-2 w-2 rounded-full bg-green-500"></span> Pagamento confirmado!';
                setTimeout(() => window.location.href = successUrl, 2000);
            } else if (data.status === 'ATIVA') {
                statusEl.className = 'inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800';
                statusEl.innerHTML = '<span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span> Aguardando pagamento';
            } else if (data.status === 'REMOVIDA_PELO_PSP' || data.status === 'REMOVIDA_PELO_USUARIO_RECEBEDOR') {
                statusEl.className = 'inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800';
                statusEl.innerHTML = '<span class="h-2 w-2 rounded-full bg-red-500"></span> Cobrança expirada';
            }
        })
        .catch(() => {});
}

setInterval(verificarStatus, 5000);
verificarStatus();
</script>

<style>
@keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
.animate-pulse-dot {
    animation: pulse-dot 2s ease-in-out infinite;
}
</style>
@endsection
