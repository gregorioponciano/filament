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

        {{-- TOTAL --}}
        <div class="mt-8 rounded-2xl bg-gray-50 p-6 text-center shadow-sm">
            <h4 class="text-lg text-gray-600">Total do pedido</h4>
            <p class="mt-2 text-3xl font-bold text-gray-900">
                R$ {{ number_format(\Cart::session(auth()->id())->getTotal(), 2, ',', '.') }}
            </p>
        </div>

        {{-- AÇÕES --}}
        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
            <form action="{{ route('carrinho.limpar') }}" method="POST">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-red-600 px-6 py-3 font-semibold
                           text-white transition hover:bg-red-700 sm:w-auto"
                >
                    Limpar carrinho
                </button>
            </form>

            <button
                class="w-full rounded-2xl bg-green-600 px-6 py-3 font-semibold
                       text-white transition hover:bg-green-700 sm:w-auto"
            >
                Finalizar compra
            </button>
        </div>

    @endif
</div>

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
