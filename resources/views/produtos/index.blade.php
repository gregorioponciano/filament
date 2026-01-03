@extends('layouts.app')
@section('title', 'Produtos')

<div class="flex">
  @foreach ($categorias as $categoria)
    <p class="p-5 bg-red-400 w-full"> {{$categoria->nome}} </p>
  @endforeach
</div>


<div class="flex justify-center">
    @foreach ($produtos as $produto)
  <!-- Conteúdo -->
  <div class="p-5 m-2 bg-blue-50">
    <img class="h-48 w-full object-cover" src="{{ $produto->imagem }}" alt="Exemplo Tailwind v4">
      <span class="mb-2 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">Categoria</span>
     <h3 class="text-2xl font-semibold text-gray-800"> {{ \Illuminate\Support\Str::limit($produto->nome, 15) }}</h3>
  <p>{{ \Illuminate\Support\Str::limit($produto->descricao, 30) }}</p>
      <!-- Botão -->
        <button class="mt-4 w-full rounded-lg bg-green-500 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition-colors"><a href="{{ route('show.detalhes', $produto->slug) }}">Detalhes</a></button>
      <button class="mt-4 w-full rounded-lg bg-blue-500 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition-colors">Comprar</button>
  </div>
  @endforeach
</div>

<div class="row">
    <p>{{ $produtos->links() }}</p>
</div> 


