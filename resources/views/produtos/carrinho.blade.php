@extends('user.dashboard')
@section('title', 'Carrinho')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-7xl px-4 py-6">

    {{-- ALERTAS --}}
    @if ($mensagem = Session::get('sucesso'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
            <h3 class="text-lg font-semibold">✅ Parabéns!</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
    @endif

    @if ($mensagem = Session::get('aviso'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
            <h3 class="text-lg font-semibold">Sucesso</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
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
            <h3 class="text-2xl font-semibold text-gray-800">
                Seu carrinho
                <span class="ml-1 text-sm font-medium text-gray-500">
                    ({{ $itens->count() }} itens)
                </span>
            </h3>

            <a
                href="{{ url('/user') }}"
                class="flex items-center gap-1 text-blue-300 hover:text-blue-400 transition h-12 w-8"
            >
                <span style="font-size: 32px;" class="material-symbols-outlined">
                    arrow_circle_left
                </span>
            </a>
        </div>

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

                    <form id="checkout-form" action="{{ route('pedido.store') }}" method="POST">
                        @csrf
                        
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
                    </form>
                </div>
            </div>

            {{-- COLUNA DA DIREITA: RESUMO --}}
            <div class="lg:col-span-4">
                <div class="sticky top-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Resumo do Pedido</h3>
                    
                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-6">
                        <span class="text-base font-medium text-gray-600">Total a pagar</span>
                        <span class="text-2xl font-bold text-green-600">
                            R$ {{ number_format(\Cart::session(Auth::id())->getTotal(), 2, ',', '.') }}
                        </span>
                    </div>

                    <button 
                        onclick="document.getElementById('checkout-form').submit()"
                        @if(Auth::user()->enderecos->count() === 0) disabled @endif
                        class="w-full rounded-xl bg-green-600 px-6 py-4 text-base font-bold text-white shadow-md transition-all hover:bg-green-700 hover:shadow-lg disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500 disabled:shadow-none"
                    >
                        Confirmar e Pagar
                    </button>

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
</script>

@endsection
