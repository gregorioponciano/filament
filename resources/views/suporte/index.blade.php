@extends('user.dashboard')

@section('title', 'Suporte')

@section('dashboard')
@include('user.dashboard-content')
   @if ($mensagem = Session::get('suporte'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
            <h3 class="text-lg font-semibold">✅ Parabéns!</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
    @endif
<div class="min-h-screen bg-gradient-to-b from-primary_color to-pink-600">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Topo / Navegação --}}
        <div class=" flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ url('/user') }}"
                class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">
                    arrow_circle_left
                </span>
                Voltar
            </a>
            <a href="{{ route('suporte.chamados') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                
                Meus chamados
            </a>
        </div>

        {{-- Cabeçalho --}}
        <header class="mb-10 text-center">

            <p class="mx-auto mt-3  text-gray-500 text-2xl">
                Como podemos te ajudar hoje?
            </p>
        </header>

        {{-- Layout em Grid (fixo em telas grandes) --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- FAQ --}}
            <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-6 text-2xl font-bold text-gray-800">
                    Perguntas Frequentes
                </h2>

                <div id="faq-accordion" class="space-y-4">

                    @php
                        $faqs = [
                            ['q' => 'Como faço para rastrear meu pedido?', 'a' => 'Você pode rastrear seu pedido acessando a seção "Meus Pedidos" em seu perfil. Lá você encontra o status e o código de rastreio.'],
                            ['q' => 'Qual é a política de devolução?', 'a' => 'Você pode devolver produtos em até 7 dias corridos após o recebimento, sem custos, desde que estejam sem uso.'],
                            ['q' => 'Como posso alterar meu endereço de entrega?', 'a' => 'Você pode gerenciar seus endereços em "Meu Perfil". Pedidos já enviados não podem ter o endereço alterado.'],
                            ['q' => 'Quais métodos de pagamento são aceitos?', 'a' => 'Aceitamos cartão de crédito, boleto e PIX em ambiente 100% seguro.'],
                            ['q' => 'Posso cancelar um pedido após a compra?', 'a' => 'Sim, desde que ainda não tenha sido enviado. Caso esteja em trânsito, siga a política de devolução.'],
                            ['q' => 'Como posso proteger minha conta?', 'a' => 'Use uma senha forte, não compartilhe seus dados e ative verificação em duas etapas se disponível.'],
                        ];
                    @endphp

                    @foreach($faqs as $faq)
                        <div class="faq-item rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <button class="faq-question flex w-full items-center justify-between text-left text-base font-semibold text-gray-800 hover:text-blue-600 transition">
                                <span>{{ $faq['q'] }}</span>
                                <svg class="faq-icon h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="faq-answer hidden mt-3 rounded-lg border-l-4 border-blue-500 bg-white p-4 text-sm text-gray-600">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- CTA Lateral (fixo em telas grandes) --}}
            <aside class="lg:sticky lg:top-6 h-fit rounded-2xl border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900">
                    Não encontrou sua resposta?
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Fale direto com nosso suporte. Respondemos rapidinho 😉
                </p>

                <button id="open-ticket-modal-btn"
                        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-blue-500/40">
                    <span class="material-symbols-outlined text-base">support_agent</span>
                    Abrir um Chamado
                </button>
            </aside>
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

{{-- JS (o mesmo que você já usa) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const item = button.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');

            const isOpen = !answer.classList.contains('hidden');

            document.querySelectorAll('.faq-answer').forEach(el => {
                el.classList.add('hidden');
                el.closest('.faq-item').querySelector('.faq-icon').classList.remove('rotate-180');
            });

            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });

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
});
</script>
@endsection
