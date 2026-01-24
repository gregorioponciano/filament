@extends('user.dashboard')

@section('title', 'Busca: ' . request('search'))

@section('dashboard')
@include('user.dashboard-content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Resultados da busca por: <span class="text-blue-600">"{{ request('search') }}"</span>
        </h2>

        @if($produtos->count() > 0)
            {{-- EXIBE PRODUTOS --}}
            @include('produtos.index')

            {{-- PAGINAÇÃO --}}
            <div class="mt-8 flex justify-center">
                @if(method_exists($produtos, 'links'))
                    {{ $produtos->appends(request()->query())->links() }}
                @endif
            </div>
        @else
            {{-- ESTADO VAZIO --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="bg-gray-50 rounded-full p-6 mb-4">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Nenhum produto encontrado</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">
                    Não encontramos resultados para sua busca. Tente termos diferentes ou navegue pelas categorias.
                </p>
                <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:underline">Ver todos os produtos</a>
            </div>
        @endif
    </div>
@endsection
