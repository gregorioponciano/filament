@extends('layouts.app')

@section('title', 'Produtos')


<div class="flex">
  @foreach ($categorias as $categoria)
    <p class="p-5 bg-orange-400 w-full">
        {{ $categoria->nome }}
    </p>
  @endforeach
</div>

<div class="p-6">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($produtos as $produto)

      <div class="p-5 m-1 bg-blue-50">

        <img
          class="h-48 w-full object-cover"
          src="{{ $produto->imagem }}"
          alt="{{ $produto->nome }}"
        >

        <span class="mb-2 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
          {{ $produto->categoria->nome ?? 'Categoria' }}
        </span>

        <h3 class="text-2xl font-semibold text-gray-800">
          {{ \Illuminate\Support\Str::limit($produto->nome, 15) }}
        </h3>

        <p>
          {{ \Illuminate\Support\Str::limit($produto->descricao, 30) }}
        </p>

        {{-- PREÇO (aqui estava o “sumido”) --}}
        <p class="mt-2 text-lg font-bold text-green-600">
          R$ {{ number_format($produto->preco, 2, ',', '.') }}
        </p>

        <button class="mt-4 w-full rounded-lg bg-green-500 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition-colors">
          <a href="{{ route('show.detalhes', $produto->slug) }}">Detalhes</a>
        </button>

        <button class="mt-2 w-full rounded-lg bg-blue-500 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition-colors">
          Comprar
        </button>

      </div>

    @endforeach

  </div>
</div>

<div class="flex justify-center">
    {{ $produtos->links() }}
</div>


