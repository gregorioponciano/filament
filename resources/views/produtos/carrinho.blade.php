@extends('user.dashboard')
@section('title', 'Carrinho')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-7xl px-4 ">

{{-- ALERTA FLUTUANTE --}}
@if ($mensagem = Session::get('sucesso'))
    <div 
        id="alert-sucesso"
        class="fixed top-5 right-5 z-50 w-[90%] max-w-sm
               rounded-2xl border border-green-200 bg-green-50 p-5 
               text-green-800 shadow-lg
               transform scale-75 opacity-0
               transition-all duration-300 ease-out
        "
    >
        <h3 class="text-base font-semibold flex items-center gap-2">
            <span>✅</span> Parabéns!
        </h3>
        <p class="mt-1 text-sm">
            {{ $mensagem }}
        </p>
    </div>
@endif

    @if ($mensagem = Session::get('aviso'))
    <div id="alert-aviso"
         class="fixed top-5 right-5 z-50 w-[90%] max-w-sm
                rounded-2xl border border-red-200 bg-red-50 p-5 
                text-red-800 shadow-lg
                transform scale-75 opacity-0
                transition-all duration-300 ease-out"
    >
        <h3 class="text-base font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600">warning</span>
            Atenção
        </h3>
        <p class="mt-1 text-sm">
            {{ $mensagem }}
        </p>
    </div>
    <script>
        (function() {
            const el = document.getElementById('alert-aviso');
            if (!el) return;
            setTimeout(() => { el.classList.remove('scale-75', 'opacity-0'); el.classList.add('scale-100', 'opacity-100'); }, 100);
            setTimeout(() => {
                el.classList.remove('scale-100', 'opacity-100');
                el.classList.add('scale-75', 'opacity-0');
                setTimeout(() => el.remove(), 300);
            }, 3000);
        })();
    </script>
    @endif

    @if ($mensagem = Session::get('erro'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
            <h3 class="text-lg font-semibold">Atenção</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
    @endif

    {{-- CARRINHO VAZIO --}}
    @if ($itens->count() === 0)
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">
                Seu carrinho
                <span class="ml-1 text-sm font-medium text-gray-500">
                    ({{ $itens->count() }} itens)
                </span>
            </h3>
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">shopping_cart</span>
            
            <h3 class="text-xl font-medium text-gray-900 mb-2">Seu carrinho está vazio</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">Aproveite nossas promoções e adicione produtos incríveis!</p>
            <a href="{{ route('user.dashboard') }}" class="rounded-lg bg-button-primary px-6 py-2.5 font-medium hover:bg-hover-primary transition">Explorar produtos</a>
        </div>
    @else

        {{-- CABEÇALHO --}}
        <div class="mb-4">


            {{-- Topo / Navegação --}}
        <div class=" flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('user.dashboard') }}"
                class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50  px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">
                    arrow_circle_left
                </span>
                Voltar
            </a>
            <button id="open-cupom-modal" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="material-symbols-outlined text-base">add</span>
                 Novo Cupom
            </button>
        </div>
        </div>
                    <h3 class=" mb-4 text-gray-500 text-2xl">
                carrinho
                <span class="ml-1 text-sm font-medium text-gray-500">
                    {{ $itens->count() }} produtos
                </span>
            </h3>

        {{-- ================= MOBILE (CARDS) ================= --}}
        <div class="space-y-4 lg:hidden">
            @foreach ($itens as $item)
                <div class="flex gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

                    {{-- IMAGEM --}}
                    <a href="{{ route('show.detalhes', $item->attributes->slug) }}">
                        <img
                            src="{{ asset('storage/' . $item->attributes->image) }}"
                            alt="{{ $item->name }}"
                            class="h-24 w-24 rounded-xl object-cover ring-1 ring-gray-200"
                        >
                    </a>

                    {{-- CONTEÚDO --}}
                    <div class="flex flex-1 flex-col justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-800 leading-tight">
                                {{ $item->name }}
                            </h4>

                            <p class="mt-1 font-bold text-gray-900">
                                R$ {{ number_format($item->price, 2, ',', '.') }}
                            </p>

                        {{-- Encontra o produto correspondente na coleção de produtos passada pelo controller --}}
                            @php 
                                $produto = $produtos->firstWhere('id', $item->id); 
                            @endphp
                            <div class="item-carrinho">
                                {{-- Exibe o estoque --}}
                                @if($produto)
                                    <p class="text-sm text-gray-500">
                                        Estoque disponível: {{ $produto->estoque }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- AÇÕES --}}
                        <div class="mt-3 flex items-center justify-between">

                            {{-- QUANTIDADE --}}
                            <form
                                action="{{ route('carrinho.atualizar') }}"
                                method="POST"
                                class="flex items-center gap-2"
                            >
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $item->id }}">

                                <button type="button" onclick="alterarQtd(this, -1)"
                                    class=" font-bold
                                    h-8 w-8 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 active:scale-95 transition text-red-600 text-2xl">
                                    −
                                </button>

                                <input
                                    type="number"
                                    name="estoque"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    class="h-8 w-10 rounded-lg border border-gray-300 text-center font-semibold
                                            appearance-none
                                            [&::-webkit-inner-spin-button]:appearance-none
                                            [&::-webkit-outer-spin-button]:appearance-none"
                                >

                                <button type="button" onclick="alterarQtd(this, 1)"
                                    class="h-8 w-8 rounded-lg border border-gray-300 bg-white text-green-600 font-semibold
                        hover:bg-gray-100 active:scale-95 transition text-2xl">
                                    +
                                </button>
                            </form>

                            {{-- REMOVER --}}
                            <form action="{{ route('carrinho.remover', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm font-medium text-red-600 hover:underline">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ================= DESKTOP (TABELA) ================= --}}
        <div class="hidden lg:block overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="p-4"></th>
                            <th class="p-4 text-left">Produto</th>
                            <th class="p-4 text-left">Preço</th>
                            <th class="p-4 text-left">Estoque</th>
                            <th class="p-4 text-left">Quantidade</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach ($itens as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">
                                    <a href="{{ route('show.detalhes', $item->attributes->slug) }}">
                                        <img
                                            src="{{ asset('storage/' . $item->attributes->image) }}"
                                            class="h-16 w-16 rounded-xl object-cover ring-1 ring-gray-200"
                                        >
                                    </a>
                                </td>

                                <td class="p-4 font-medium text-gray-800">
                                    {{ $item->name }}
                                </td>

                                <td class="p-4 font-semibold text-gray-700">
                                    R$ {{ number_format($item->price, 2, ',', '.') }}
                                </td>

                                <td class="p-4 font-semibold text-gray-700">
 {{-- Encontra o produto correspondente na coleção de produtos passada pelo controller --}}
                            @php 
                                $produto = $produtos->firstWhere('id', $item->id); 
                            @endphp

                            <div class="item-carrinho">
                                
                                {{-- Exibe o estoque --}}
                                @if($produto)
                                    <p class=" text-gray-500">
                                        {{ $produto->estoque }}
                                    </p>
                                @endif
                            </div>
                                </td>


                                <td class="p-4">
                                    <form
                                        action="{{ route('carrinho.atualizar') }}"
                                        method="POST"
                                        class="flex items-center gap-2"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $item->id }}">

                                        <button type="button" onclick="alterarQtd(this, -1)"
                                            class="h-8 w-8 font-semibold rounded-lg border border-gray-300 bg-white hover:bg-gray-100 active:scale-95 transition text-red-600 text-2xl">−</button>

                                        <input
                                            type="number"
                                            name="estoque"
                                            value="{{ $item->quantity }}"
                                            class="h-8 w-12 rounded-lg border text-center font-semibold
                                                    appearance-none
                                                    [&::-webkit-inner-spin-button]:appearance-none
                                                    [&::-webkit-outer-spin-button]:appearance-none"
                                        >

                                        <button type="button" onclick="alterarQtd(this, 1)"
                                            class="h-8 w-8 font-semibold rounded-lg border border-gray-300 bg-white hover:bg-gray-100 active:scale-95 transition text-green-600 text-2xl">+</button>
                                    </form>
                                </td>

                                <td class="p-4 text-right">
                                    <form action="{{ route('carrinho.remover', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">
                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CUPOM MODAL --}}
        <div id="cupom-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl animate-fade-in-up">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Cupom de Desconto</h3>
                    <button id="close-cupom-modal" class="text-gray-400 hover:text-gray-600 transition">
                        <span class="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>
                <div class="flex gap-2">
                    <input type="text" id="cupom-input" placeholder="Digite o código do cupom"
                           class="flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                           maxlength="50">
                    <button id="cupom-apply-btn"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Aplicar
                    </button>
                </div>
                <p id="cupom-feedback" class="mt-3 text-sm hidden"></p>
            </div>
        </div>

        {{-- CUPOM APPLIED BANNER --}}
        @php $cupomSession = session('cupom'); @endphp
        @if($cupomSession)
        <div id="cupom-applied" class="mb-4 rounded-2xl border border-green-200 bg-green-50 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-600">redeem</span>
                    <div>
                        <p class="font-semibold text-green-800">Cupom aplicado: <span class="uppercase">{{ $cupomSession['code'] }}</span></p>
                        <p class="text-sm text-green-600">Desconto de R$ {{ number_format($cupomSession['discount'], 2, ',', '.') }}</p>
                    </div>
                </div>
                <button id="cupom-remove-btn" class="text-sm font-medium text-red-600 hover:text-red-800 transition">
                    Remover
                </button>
            </div>
        </div>
        @else
        <div id="cupom-applied" class="hidden mb-4 rounded-2xl border border-green-200 bg-green-50 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-600">redeem</span>
                    <div>
                        <p class="font-semibold text-green-800">Cupom aplicado: <span id="cupom-code-display" class="uppercase"></span></p>
                        <p class="text-sm text-green-600">Desconto de R$ <span id="cupom-discount-display"></span></p>
                    </div>
                </div>
                <button id="cupom-remove-btn" class="text-sm font-medium text-red-600 hover:text-red-800 transition">
                    Remover
                </button>
            </div>
        </div>
        @endif

        {{-- CHECKOUT AREA --}}
        <div class="mt-10 grid grid-cols-1 gap-8 lg:grid-cols-12 items-start">
            
            {{-- COLUNA DA ESQUERDA: ENDEREÇOS --}}
            <div class="lg:col-span-8">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">location_on</span>
                            Endereço de Entrega
                        </h3>
                        <a href="{{ route('store.profile') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            + Novo endereço
                        </a>
                    </div>

                    @if(Auth::user()->enderecos->count() > 0)
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach(Auth::user()->enderecos as $index => $endereco)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="endereco_id" value="{{ $endereco->id }}" class="peer sr-only" {{ $index === 0 ? 'checked' : '' }}>
                                    
                                    <div class="h-full rounded-xl border-2 border-gray-100 bg-white p-4 transition-all duration-200 hover:border-blue-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 peer-checked:shadow-sm">
                                        <div class="flex items-start justify-between mb-2">
                                            <span class="font-semibold text-gray-900">{{ $endereco->apelido ?? 'Minha Casa' }}</span>
                                            <div class="hidden h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-white peer-checked:flex">
                                                <span class="material-symbols-outlined text-[14px] font-bold">check</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $endereco->rua }}, {{ $endereco->numero }}<br>
                                            {{ $endereco->bairro }} - {{ $endereco->cidade }}/{{ $endereco->uf }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 py-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">no_meeting_room</span>
                            <p class="text-gray-500 mb-4">Você não possui endereços cadastrados.</p>
                            <a href="{{ route('store.profile') }}" class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow transition-colors hover:bg-gray-700">
                                Cadastrar Endereço Agora
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- COLUNA DA DIREITA: RESUMO --}}
            <div class="lg:col-span-4">
                <div class="sticky top-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Resumo do Pedido</h3>

                    @php
                        $cartTotal = \Cart::session(Auth::id())->getTotal();
                        $cupomSession = session('cupom');
                        $cupomDesconto = $cupomSession['discount'] ?? 0;
                        $totalFinal = max(0, $cartTotal - $cupomDesconto);
                    @endphp

                    @if($cupomDesconto > 0)
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-500">Subtotal</span>
                        <span class="text-sm text-gray-700">R$ {{ number_format($cartTotal, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-green-600 font-medium">Desconto</span>
                        <span class="text-sm text-green-600 font-medium">- R$ {{ number_format($cupomDesconto, 2, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-6">
                        <span class="text-base font-medium text-gray-600">Total a pagar</span>
                        <span id="total-display" class="text-2xl font-bold text-green-600">
                            R$ {{ number_format($totalFinal, 2, ',', '.') }}
                        </span>
                    </div>

                    {{-- PAYMENT TABS --}}
                    <div class="mb-6" x-data="paymentTabs()">
                        {{-- Tab Headers --}}
                        <div class="flex rounded-xl border border-gray-200 overflow-hidden mb-4">
                            <button @click="tab = 'pix'" :class="tab === 'pix' ? 'bg-green-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                                    class="flex-1 px-3 py-3 text-sm font-semibold transition-all flex items-center justify-center gap-1.5">
                                <svg class="h-5 w-5" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="32" height="32" rx="8" fill="currentColor" opacity="0.2"/>
                                    <path d="M10 20L16 12L22 20H10Z" fill="currentColor"/>
                                </svg>
                                PIX
                            </button>
                            <button @click="tab = 'boleto'" :class="tab === 'boleto' ? 'bg-blue-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                                    class="flex-1 px-3 py-3 text-sm font-semibold transition-all flex items-center justify-center gap-1.5 border-x border-gray-200">
                                <span class="material-symbols-outlined text-lg">receipt_long</span>
                                Boleto
                            </button>
                            <button @click="tab = 'card'" :class="tab === 'card' ? 'bg-purple-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                                    class="flex-1 px-3 py-3 text-sm font-semibold transition-all flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-lg">credit_card</span>
                                Cartão
                            </button>
                        </div>

                        {{-- PIX Tab --}}
                        <div x-show="tab === 'pix'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="pix">
                                <input type="hidden" name="endereco_id" id="endereco_id_pix" value="{{ Auth::user()->enderecos->first()?->id }}">
                                <button type="submit"
                                    @if(Auth::user()->enderecos->count() === 0) disabled @endif
                                    class="w-full rounded-xl bg-green-600 px-6 py-4 text-base font-bold text-white shadow-md transition-all hover:bg-green-700 hover:shadow-lg disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500 disabled:shadow-none flex items-center justify-center gap-2">
                                    <svg class="h-6 w-6" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" rx="8" fill="white" opacity="0.3"/>
                                        <path d="M10 20L16 12L22 20H10Z" fill="white"/>
                                    </svg>
                                    Pagar com PIX
                                </button>
                            </form>
                            <p class="mt-2 text-xs text-gray-500 text-center"> Pagamento instantâneo, confirmação em segundos</p>
                        </div>

                        {{-- Boleto Tab --}}
                        <div x-show="tab === 'boleto'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="boleto">
                                <input type="hidden" name="endereco_id" id="endereco_id_boleto" value="{{ Auth::user()->enderecos->first()?->id }}">
                                <button type="submit"
                                    @if(Auth::user()->enderecos->count() === 0) disabled @endif
                                    class="w-full rounded-xl bg-blue-600 px-6 py-4 text-base font-bold text-white shadow-md transition-all hover:bg-blue-700 hover:shadow-lg disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500 disabled:shadow-none flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">receipt_long</span>
                                    Gerar Boleto
                                </button>
                            </form>
                            <p class="mt-2 text-xs text-gray-500 text-center">Vencimento em 3 dias úteis</p>
                        </div>

                        {{-- Cartão Tab --}}
                        <div x-show="tab === 'card'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <form id="card-form" action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="credit_card">
                                <input type="hidden" name="endereco_id" id="endereco_id_card" value="{{ Auth::user()->enderecos->first()?->id }}">
                                <input type="hidden" name="payment_token" id="payment_token" value="">
                                <input type="hidden" name="card_mask" id="card_mask" value="">
                                <input type="hidden" name="installments" id="installments" value="1">

                                <div class="space-y-3 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Número do Cartão</label>
                                        <input type="text" id="card-number" inputmode="numeric" maxlength="19"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                               placeholder="0000 0000 0000 0000">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome no Cartão</label>
                                        <input type="text" id="card-name"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                               placeholder="Nome como está no cartão">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Validade</label>
                                            <input type="text" id="card-expiry" maxlength="7"
                                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                                   placeholder="MM/AAAA">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                            <input type="text" id="card-cvv" inputmode="numeric" maxlength="4"
                                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                                   placeholder="123">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Parcelas</label>
                                        @php $cartTotal = \Cart::session(Auth::id())->getTotal(); $cupomSession = session('cupom'); $cartTotalFinal = max(0, $cartTotal - ($cupomSession['discount'] ?? 0)); @endphp
                                        <select id="card-installments"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                                            <option value="1">1x de R$ {{ number_format($cartTotalFinal, 2, ',', '.') }}</option>
                                            <option value="2">2x de R$ {{ number_format($cartTotalFinal / 2, 2, ',', '.') }}</option>
                                            <option value="3">3x de R$ {{ number_format($cartTotalFinal / 3, 2, ',', '.') }}</option>
                                            <option value="4">4x de R$ {{ number_format($cartTotalFinal / 4, 2, ',', '.') }}</option>
                                            <option value="5">5x de R$ {{ number_format($cartTotalFinal / 5, 2, ',', '.') }}</option>
                                            <option value="6">6x de R$ {{ number_format($cartTotalFinal / 6, 2, ',', '.') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="card-error" class="hidden mb-3 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700"></div>

                                <button type="submit" id="card-submit-btn"
                                    @if(Auth::user()->enderecos->count() === 0) disabled @endif
                                    class="w-full rounded-xl bg-purple-600 px-6 py-4 text-base font-bold text-white shadow-md transition-all hover:bg-purple-700 hover:shadow-lg disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500 disabled:shadow-none flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">lock</span>
                                    Pagar com Cartão
                                </button>
                            </form>
                        </div>
                    </div>

                    <script src="https://assets.efipay.com.br/efi-checkout-utils.js"></script>
                    <script>
                    function paymentTabs() {
                        return { tab: 'pix' };
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        const cardForm = document.getElementById('card-form');
                        if (!cardForm) return;

                        cardForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const btn = document.getElementById('card-submit-btn');
                            const errorEl = document.getElementById('card-error');

                            btn.disabled = true;
                            btn.innerHTML = '<span class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span> Processando...';
                            errorEl.classList.add('hidden');

                            const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
                            const cardName = document.getElementById('card-name').value;
                            const cardExpiry = document.getElementById('card-expiry').value;
                            const cardCvv = document.getElementById('card-cvv').value;
                            const installments = document.getElementById('card-installments').value;

                            // Validate fields
                            if (!cardNumber || !cardName || !cardExpiry || !cardCvv) {
                                showCardError(errorEl, btn, 'Preencha todos os dados do cartão.');
                                return;
                            }

                            // Parse expiry
                            const [expMonth, expYear] = cardExpiry.split('/');
                            if (!expMonth || !expYear || expMonth < 1 || expMonth > 12 || expYear.length !== 4) {
                                showCardError(errorEl, btn, 'Data de validade inválida. Use MM/AAAA.');
                                return;
                            }

                            try {
                                const brand = await getBrand(cardNumber);
                                if (!brand) {
                                    showCardError(errorEl, btn, 'Bandeira do cartão não reconhecida.');
                                    return;
                                }

                                document.getElementById('installments').value = installments;

                                // Generate payment token via Efí SDK
                                const paymentToken = await EfiCheckoutUtils.createPaymentToken({
                                    brand: brand,
                                    number: cardNumber,
                                    cvv: cardCvv,
                                    expiration_month: expMonth,
                                    expiration_year: expYear,
                                    holder_name: cardName,
                                });

                                if (!paymentToken) {
                                    showCardError(errorEl, btn, 'Erro ao gerar token de pagamento.');
                                    return;
                                }

                                document.getElementById('payment_token').value = paymentToken;
                                document.getElementById('card_mask').value = '****.****.****.' + cardNumber.slice(-4);

                                // Submit form
                                const form = e.target;
                                const hiddenSubmit = document.createElement('button');
                                hiddenSubmit.type = 'submit';
                                hiddenSubmit.style.display = 'none';
                                form.appendChild(hiddenSubmit);
                                hiddenSubmit.click();
                            } catch (err) {
                                console.error('Card error:', err);
                                showCardError(errorEl, btn, 'Erro ao processar cartão: ' + (err.message || 'Tente novamente.'));
                            }
                        });

                        // Card number formatting
                        document.getElementById('card-number').addEventListener('input', function() {
                            this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ');
                        });

                        // Expiry formatting
                        document.getElementById('card-expiry').addEventListener('input', function() {
                            this.value = this.value.replace(/\D/g, '');
                            if (this.value.length > 2) {
                                this.value = this.value.slice(0, 2) + '/' + this.value.slice(2, 6);
                            }
                        });

                        // CVV numbers only
                        document.getElementById('card-cvv').addEventListener('input', function() {
                            this.value = this.value.replace(/\D/g, '');
                        });
                    });

                    function showCardError(errorEl, btn, message) {
                        errorEl.textContent = message;
                        errorEl.classList.remove('hidden');
                        btn.disabled = false;
                        btn.innerHTML = '<span class="material-symbols-outlined">lock</span> Pagar com Cartão';
                    }

                    async function getBrand(cardNumber) {
                        const first = cardNumber[0];
                        const firstTwo = cardNumber.slice(0, 2);
                        const firstFour = cardNumber.slice(0, 4);
                        if (first === '4') return 'visa';
                        if (['51','52','53','54','55'].includes(firstTwo)) return 'mastercard';
                        if (['34','37'].includes(firstTwo)) return 'amex';
                        if (['36','38','301','302','303','304','305'].includes(firstTwo) || ['309','636'].some(p => firstTwo.startsWith(p))) return 'hipercard';
                        if (['5067','4576','4011','5090','6500','6363','6069'].includes(firstFour) || ['4389','5042','3841','6373','6374','6375','6376'].includes(firstFour)) return 'elo';
                        return null;
                    }
                    </script>

                    <form action="{{ route('carrinho.limpar') }}" method="POST" class="mt-4 text-center">
                    @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors">
                            Esvaziar carrinho
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @endif

{{-- SCRIPT --}}
<script>
function alterarQtd(botao, valor) {
    const form = botao.closest('form');
    const input = form.querySelector('input[name="estoque"]');

    let atual = parseInt(input.value) || 1;
    let novo = atual + valor;

    if (novo < 1) novo = 1;

    input.value = novo;
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    const enderecoRadios = document.querySelectorAll('input[name="endereco_id"]');
    if (enderecoRadios.length > 0) {
        enderecoRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('[id^="endereco_id_"]').forEach(input => {
                    input.value = this.value;
                });
            });
        });
    }

    // Cupom modal
    const openBtn = document.getElementById('open-cupom-modal');
    const modal = document.getElementById('cupom-modal');
    const closeBtn = document.getElementById('close-cupom-modal');
    if (openBtn && modal && closeBtn) {
        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });
    }

    // Cupom apply AJAX
    document.getElementById('cupom-apply-btn')?.addEventListener('click', async function() {
        const input = document.getElementById('cupom-input');
        const feedback = document.getElementById('cupom-feedback');
        const code = input.value.trim();
        if (!code) { feedback.textContent = 'Digite um código.'; feedback.className = 'mt-3 text-sm text-red-600'; feedback.classList.remove('hidden'); return; }

        this.disabled = true;
        this.textContent = '...';

        try {
            const res = await fetch('{{ route("cupom.apply") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code })
            });
            const data = await res.json();
            if (data.success) {
                feedback.className = 'mt-3 text-sm text-green-600';
                feedback.textContent = data.message;
                feedback.classList.remove('hidden');
                setTimeout(() => location.reload(), 800);
            } else {
                feedback.className = 'mt-3 text-sm text-red-600';
                feedback.textContent = data.message || 'Erro ao aplicar cupom.';
                feedback.classList.remove('hidden');
            }
        } catch (err) {
            feedback.className = 'mt-3 text-sm text-red-600';
            feedback.textContent = 'Erro de conexão. Tente novamente.';
            feedback.classList.remove('hidden');
        }
        this.disabled = false;
        this.textContent = 'Aplicar';
    });

    // Cupom remove
    document.getElementById('cupom-remove-btn')?.addEventListener('click', async function() {
        try {
            await fetch('{{ route("cupom.remove") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            });
            location.reload();
        } catch (err) {
            location.reload();
        }
    });
});
</script>

@endsection
