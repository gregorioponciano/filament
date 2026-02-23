@extends('user.dashboard')
@section('title', 'Meus Favoritos')

@section('dashboard')
@include('user.dashboard-content')

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Cabeçalho --}}
            <header class="mb-4 text-center">
                <p class="mx-auto  text-gray-500 text-2xl">
                    Meus Favoritos {{$produtos->count()}}
                </p>
            </header>
            {{-- Topo / Navegação --}}
            <div class=" flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 mb-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ url('/user') }}"
                    class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                    <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">
                        arrow_circle_left
                    </span>
                    Voltar
                </a>
                <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    ...
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if(isset($produtos) && $produtos->count() > 0)
                @include('produtos.index')
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
                    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">favorite_border</span>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Você ainda não tem favoritos</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">Salve os produtos que você mais gosta aqui para encontrá-los facilmente depois.</p>
                    <a href="{{ route('user.dashboard') }}" class="rounded-lg bg-button-primary px-6 py-2.5 font-medium hover:bg-hover-primary transition">Explorar produtos</a>
                </div>
            @endif
        </div>
@endsection