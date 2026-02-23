@extends('user.dashboard')

@section('title', 'Busca: ' . request('search'))

@section('dashboard')
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Cabeçalho da Busca --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Resultados para: <span class="text-blue-600 break-words">"{{ request('search') }}"</span>
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                🔎 Encontramos <strong>{{ $produtos->total() }}</strong> produto(s)
            </p>
        </div>

        <a href="{{ route('user.dashboard') }}" 
           class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm hover:bg-gray-50 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-xl transition group-hover:-translate-x-0.5">
                arrow_back
            </span>
            Voltar
        </a>
    </div>

    @if($produtos->count() > 0)

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($produtos as $produto)
                <div class="group relative flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all duration-300">
                    
                    {{-- IMAGEM --}} 
                    <div class=" w-full overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" 
                             alt="{{ $produto->nome }}"
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        {{-- CATEGORIA & FAVORITO --}}
                        <div class="mb-2 flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                {{ $produto->categoria->nome ?? 'Geral' }}
                            </span>
                            
                            <form action="{{ route('favorites.toggle') }}" method="POST" class="inline-flex">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                <button type="submit" class="cursor-pointer transition-colors {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                                    <span class="material-symbols-outlined text-xl">favorite</span>
                                </button>
                            </form>
                        </div>

                        {{-- NOME --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1" title="{{ $produto->nome }}">
                            {{ $produto->nome }}
                        </h3>

                        {{-- DESCRIÇÃO --}}
                        <p class="text-sm text-gray-500 mb-4 flex-1 line-clamp-2" title="{{ $produto->descricao }}">
                            {{ $produto->descricao }}
                        </p>

                        {{-- PREÇO & ESTOQUE --}}
                        <div class="flex flex-row items-center justify-between gap-4 mb-4">
                            <p class="text-xl font-bold text-gray-900">
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $produto->estoque }} un.
                            </p>
                        </div>

                        {{-- AÇÕES --}}
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 gap-3">
                            <a href="{{ route('show.detalhes', $produto->slug) }}" class="flex-1 rounded-lg bg-yellow-500 px-3 py-2 text-center text-sm font-medium text-white hover:bg-yellow-600 transition">
                                Detalhes
                            </a>
                            <form action="{{ route('site.addcarrinho') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="id" value="{{ $produto->id }}">
                                <input type="hidden" name="nome" value="{{ $produto->nome }}">
                                <input type="hidden" name="preco" value="{{ $produto->preco }}">
                                <input type="hidden" name="estoque" value="1">
                                <input type="hidden" name="imagem" value="{{ $produto->imagem }}">
                                <input type="hidden" name="slug" value="{{ $produto->slug }}">
                                <button type="submit" class="w-full rounded-lg bg-blue-600 px-3 py-2 text-center text-sm font-medium text-white hover:bg-blue-700 transition">
                                    Comprar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginação Responsiva --}}
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-4">

            <p class="text-sm text-gray-500 text-center sm:text-left">
                Mostrando 
                <strong>{{ $produtos->firstItem() }}</strong> 
                até 
                <strong>{{ $produtos->lastItem() }}</strong> 
                de 
                <strong>{{ $produtos->total() }}</strong>
            </p>

<div class="m-8 flex justify-center">
  @if(method_exists($produtos, 'links'))
    {{ $produtos->appends(request()->query())->links() }}
  @endif
</div>

        </div>

    @else
        {{-- Estado vazio --}}
        <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="bg-gray-50 rounded-full p-6 mb-6">
                <span class="material-symbols-outlined text-5xl text-gray-300">
                    search_off
                </span>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">
                Nenhum resultado encontrado
            </h3>

            <p class="text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">
                Não encontramos produtos para "<strong>{{ request('search') }}</strong>".
            </p>

            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                Ver todos os produtos
            </a>
        </div>
    @endif

</div>
@endsection