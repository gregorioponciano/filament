<div>
    {{-- Status do pagamento com atualização automática --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">Status do Pagamento</h3>

            <div class="flex items-center gap-2">
                @if($status === 'pending')
                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-500">Atualizando...</span>
                @endif

                <button wire:click="checkStatus"
                    class="text-sm text-amber-600 hover:text-amber-800">
                    Verificar agora
                </button>
            </div>
        </div>

        <div class="mt-4">
            <span class="text-2xl font-bold {{ $this->getStatusColor() }}">
                {{ $this->getStatusLabel() }}
            </span>
        </div>

        @if($status === 'paid')
            <div class="mt-4 bg-green-50 border border-green-200 rounded p-4">
                <p class="text-green-700 font-semibold">✅ Pagamento confirmado com sucesso!</p>
                <p class="text-green-600 text-sm mt-1">Seu pedido está sendo processado.</p>
            </div>
        @elseif($status === 'cancelled' || $status === 'expired')
            <div class="mt-4 bg-red-50 border border-red-200 rounded p-4">
                <p class="text-red-700 font-semibold">❌ Pagamento {{ $this->getStatusLabel() }}</p>
                <p class="text-red-600 text-sm mt-1">Tente novamente com outro método de pagamento.</p>
            </div>
        @endif
    </div>

    {{-- Polling automático enquanto estiver pendente --}}
    @if($this->isPending())
        <div wire:poll.{{ $pollingInterval }}s="refreshStatus"></div>
    @endif
</div>
