@extends('user.dashboard')
@section('title', 'Suporte')

@section('dashboard')
@include('user.dashboard-content')

<x-flash-messages />

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="animate-fade-in-up flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 mb-6 shadow-sm">
        <a href="{{ url('/user') }}"
            class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">arrow_circle_left</span>
            Voltar
        </a>
        <a href="{{ route('suporte.chamados') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
            <span class="material-symbols-outlined text-base">list_alt</span>
            Meus chamados
        </a>
    </div>

    <div class="text-center mb-10 animate-fade-in-up stagger-1">
        <span class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
            <span class="material-symbols-outlined text-3xl text-blue-600">support_agent</span>
        </span>
        <h1 class="text-3xl font-bold text-gray-900">Como podemos ajudar?</h1>
        <p class="mt-2 text-gray-500">Tire suas dúvidas ou abra um chamado para atendimento personalizado.</p>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4 animate-fade-in-up stagger-2">
            @php
                $faqs = [
                    ['q' => 'Como faço para rastrear meu pedido?', 'a' => 'Acesse "Meus Pedidos" no seu perfil. Lá você encontra o status e o código de rastreio.'],
                    ['q' => 'Qual é a política de devolução?', 'a' => 'Você pode devolver produtos em até 7 dias corridos após o recebimento, sem custos, desde que estejam sem uso.'],
                    ['q' => 'Como alterar meu endereço de entrega?', 'a' => 'Gerencie seus endereços em "Meu Perfil". Pedidos já enviados não podem ter o endereço alterado.'],
                    ['q' => 'Quais métodos de pagamento são aceitos?', 'a' => 'Aceitamos cartão de crédito, boleto e PIX em ambiente 100% seguro.'],
                    ['q' => 'Posso cancelar um pedido?', 'a' => 'Sim, desde que ainda não tenha sido enviado. Caso esteja em trânsito, siga a política de devolução.'],
                ];
            @endphp

            @foreach($faqs as $faq)
                <div class="faq-item rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
                    <button class="faq-question flex w-full items-center justify-between text-left gap-4">
                        <span class="text-base font-semibold text-gray-800">{{ $faq['q'] }}</span>
                        <svg class="faq-icon h-5 w-5 shrink-0 transform transition-transform duration-300 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden mt-3 pt-3 border-t border-gray-100 text-sm text-gray-600 leading-relaxed">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <aside class="animate-fade-in-up stagger-3 lg:sticky lg:top-24 h-fit rounded-2xl border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm text-center">
            <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-blue-100">
                <span class="material-symbols-outlined text-2xl text-blue-600">forum</span>
            </span>
            <h3 class="text-lg font-bold text-gray-900">Não encontrou?</h3>
            <p class="mt-2 text-sm text-gray-600">Fale direto com nosso suporte. Respondemos rápido!</p>
            <button data-modal="ticket"
                    class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition">
                <span class="material-symbols-outlined text-base">support_agent</span>
                Abrir Chamado
            </button>
        </aside>
    </div>
</div>

<x-ticket-modal />

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            const isOpen = !answer.classList.contains('hidden');
            document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(el => el.classList.remove('rotate-180'));
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
});
</script>
@endsection
