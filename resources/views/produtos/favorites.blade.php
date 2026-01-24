@extends('user.dashboard')
@section('title', 'Meus Favoritos')

@section('dashboard')
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Meus Favoritos</h2>

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