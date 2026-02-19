@extends('user.dashboard')

@section('title', 'Detalhes do Chamado')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
     {{-- Topo / Navegação --}}
        <div class=" flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between mb-4">
            <a href="{{ url('/suporte') }}"
                class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">
                    arrow_circle_left
                </span>
                Voltar
            </a>
            <button id="open-ticket-modal-btn" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="material-symbols-outlined text-base">add</span>
                Novo Chamado
            </button>
        </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        {{-- Cabeçalho do Chamado --}}
        <div class="border-b border-gray-200 bg-gray-50 p-6">
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $suporte->assunto }}</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Aberto em {{ $suporte->created_at->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}
                    </p>
                </div>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold leading-5
                    @if($suporte->status == 'aberto') bg-green-100 text-green-800 @elseif($suporte->status == 'fechado') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif">
                    Status: {{ ucfirst($suporte->status) }}
                </span>
            </div>
        </div>

        {{-- Corpo da Conversa --}}
        <div class="space-y-8 p-6 sm:p-8">
            {{-- Mensagem do Usuário --}}
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-gray-600">
                        <span class="material-symbols-outlined">person</span>
                    </span>
                </div>
                <div class="flex-grow rounded-xl rounded-tl-none border border-gray-200 bg-gray-50 p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">{{ $suporte->user->name }} (Você)</p>
                        <p class="text-xs text-gray-500">{{ $suporte->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        <p class="whitespace-pre-wrap">{{ $suporte->mensagem }}</p>
                    </div>
                </div>
            </div>

            {{-- Resposta do Suporte --}}
            @if($suporte->resposta)
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <span class="material-symbols-outlined">support_agent</span>
                        </span>
                    </div>
                    <div class="flex-grow rounded-xl rounded-tr-none border border-blue-200 bg-blue-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <p class="text-sm font-semibold text-blue-900">Equipe de Suporte</p>
                            {{-- Futuramente, pode-se adicionar um campo 'responded_at' --}}
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            <p class="whitespace-pre-wrap">{{ $suporte->resposta }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="border-t border-gray-200 pt-8 text-center">
                    <p class="text-sm text-gray-500">Nossa equipe de suporte ainda não respondeu a este chamado.</p>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- MODAL --}}
<div id="ticket-modal" class="fixed inset-0 z-100 hidden overflow-y-auto">
    <div id="ticket-modal-backdrop" class="fixed inset-0 bg-black/70"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div id="ticket-modal-panel"
             class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 shadow-xl transition-all opacity-0 scale-95">
            <form id="ticket-form" action="{{ route('store.suporte') }}" method="POST" class="space-y-5">
                @csrf
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Abrir Chamado</h3>
                    <button type="button" id="close-ticket-modal-btn" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>

                <div>
                    <label for="assunto" class="mb-1 block text-sm font-semibold text-gray-700">Assunto</label>
                    <input id="assunto" type="text" required name="assunto"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('assunto')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="mensagem" class="mb-1 block text-sm font-semibold text-gray-700">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" required rows="4"
                              class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" class="close-modal-btn rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-50">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modal = document.getElementById('ticket-modal');
    const panel = document.getElementById('ticket-modal-panel');
    const openBtn = document.getElementById('open-ticket-modal-btn');
    const closeBtns = document.querySelectorAll('#close-ticket-modal-btn, .close-modal-btn, #ticket-modal-backdrop');

    const openModal = () => {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => panel.classList.remove('opacity-0','scale-95'), 10);
    };

    const closeModal = () => {
        panel.classList.add('opacity-0','scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    };

    openBtn.addEventListener('click', openModal);
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    const ticketForm = document.getElementById('ticket-form');
    if (ticketForm) {
        ticketForm.addEventListener('submit', (e) => {
            const submitButton = ticketForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `<span class="flex items-center gap-2">Enviando...</span>`;
            }
        });
    }

</script>
@endsection
