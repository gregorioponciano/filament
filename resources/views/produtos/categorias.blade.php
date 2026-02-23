@extends('user.dashboard')

@section('title', 'Categorias')

@section('dashboard')
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Cabeçalho --}}
    <header class="mb-6 text-center">
        <h3 class="text-2xl font-bold text-gray-800">
            Categorias
            <span class="ml-1 text-sm font-medium text-gray-500">
                ({{ $totalProdutos }} itens)
            </span>
        </h3>
    </header>

    {{-- Topo / Navegação --}}
    <div class="mb-6 flex justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ url('/user') }}"
           class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition-transform group-hover:-translate-x-1">
                arrow_circle_left
            </span>
            Voltar
        </a>

        <a href="#"
           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            ...
        </a>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($produtos as $produto)

            <div class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-lg">

                {{-- IMAGEM --}}
                <div class="relative aspect-[4/3] w-full overflow-hidden bg-gray-100">
                    <img 
                        src="{{ asset('storage/' . $produto->imagem) }}" 
                        alt="{{ $produto->nome }}"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                </div>

                <div class="flex flex-1 flex-col p-5">

                    {{-- CATEGORIA & FAVORITO --}}
                    <div class="mb-3 flex items-center justify-between">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                            {{ $produto->categoria->nome ?? 'Geral' }}
                        </span>

                        <form action="{{ route('favorites.toggle') }}" method="POST" class="inline-flex">
                            @csrf
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                            <button 
                                type="submit"
                                class="transition-colors {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                                <span class="material-symbols-outlined text-xl">favorite</span>
                            </button>
                        </form>
                    </div>

                    {{-- NOME --}}
                    <h3 class="mb-1 line-clamp-1 text-base sm:text-lg font-bold text-gray-900" title="{{ $produto->nome }}">
                        {{ \Illuminate\Support\Str::limit($produto->nome, 40) }}
                    </h3>

                    {{-- DESCRIÇÃO --}}
                    <p class="mb-4 line-clamp-2 text-sm text-gray-500 flex-1" title="{{ $produto->descricao }}">
                        {{ \Illuminate\Support\Str::limit($produto->descricao, 60) }}
                    </p>

                    {{-- PREÇO & ESTOQUE --}}
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <p class="text-lg sm:text-xl font-bold text-gray-900">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $produto->estoque }} unidades
                        </p>
                    </div>

                    {{-- AÇÕES --}}
                    <div class="mt-auto flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
                        <a 
                            href="{{ route('show.detalhes', $produto->slug) }}"
                            class="flex-1 rounded-lg bg-yellow-500 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-yellow-600 transition"
                            title="Ver detalhes">
                            Detalhes
                        </a>

                        <form action="{{ route('site.addcarrinho') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="id" value="{{ $produto->id }}">
                            <input type="hidden" name="nome" value="{{ $produto->nome }}">
                            <input type="hidden" name="preco" value="{{ $produto->preco }}">
                            <input type="hidden" name="imagem" value="{{ $produto->imagem }}">
                            <input type="hidden" name="estoque" value="1">
                            <input type="hidden" name="slug" value="{{ $produto->slug }}">

                            <button 
                                type="submit"
                                class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition"
                                title="Adicionar ao carrinho">
                                Comprar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        @endforeach

    </div>
</div>

{{-- Paginação --}}
<div class="mt-10 flex justify-center px-4">
    @if(method_exists($produtos, 'links'))
        {{ $produtos->appends(request()->query())->links() }}
    @endif
</div>

@endsection