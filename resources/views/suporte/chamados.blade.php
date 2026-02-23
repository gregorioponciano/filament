@extends('user.dashboard')

@section('title', 'Meus Chamados')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Notificação de Sucesso --}}
    @if (session('sucesso'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="mt-1 text-lg">✅</span>
                <div>
                    <h3 class="font-semibold">Sucesso!</h3>
                    <p class="mt-1 text-sm">{{ session('sucesso') }}</p>
                </div>
            </div>
        </div>
    @endif
    <p class="mb-4 text-center mx-auto text-gray-500 text-2xl">Acompanhe os seus pedidos de ajuda.</p>
            {{-- Topo / Navegação --}}
        <div class=" flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('show.suporte') }}"
                class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
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

    <div class="mb-4 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        @if($chamados->isEmpty())
            <div class="p-8 text-center">
                <div class="mx-auto w-fit rounded-full bg-blue-100 p-4">
                    <span class="material-symbols-outlined text-4xl text-blue-600">inbox</span>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-gray-800">Nenhum chamado encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Você ainda não abriu nenhum chamado de suporte.</p>
                <a href="{{ route('show.suporte') }}" class="mt-4 inline-block rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                    Precisa de ajuda?
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Assunto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Data de Abertura
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($chamados as $chamado)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('suporte.detalhes', $chamado) }}';">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $chamado->assunto }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($chamado->mensagem, 80) }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold leading-5
                                        @if($chamado->status == 'aberto') bg-green-100 text-green-800 @elseif($chamado->status == 'fechado') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($chamado->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                                    {{ $chamado->created_at->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($chamados->hasPages())
                <div class="border-t border-gray-200 bg-white px-4 py-3">
                    {{ $chamados->links() }}
                </div>
            @endif
        @endif
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