@extends('user.dashboard')

@section('title', 'Categorias')

@section('dashboard')
<div class="p-6">
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

    @foreach ($produtos as $produto)

      <div class="m-1 rounded-xl bg-blue-50 p-5 shadow-sm transition hover:shadow-md">

        {{-- IMAGEM + BOTÃO DETALHES --}}
        <div class="group relative mb-4 overflow-hidden rounded-lg">
          <img
            class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
            src="{{ asset($produto->imagem) }}"
            alt="{{ $produto->nome }}"
          >

          {{-- Overlay --}}
          <div class="absolute inset-0 bg-black/40 opacity-0 transition group-hover:opacity-100"></div>

          {{-- Botão Ver Detalhes --}}
          <a
            href="{{ route('show.detalhes', $produto->slug) }}"
            class="absolute inset-0 flex items-center justify-center opacity-0 transition group-hover:opacity-100"
          >
            <span class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-gray-800 shadow hover:bg-gray-100">
              👁 Ver detalhes
            </span>
          </a>
        </div>

        {{-- CATEGORIA --}}
        <span class="mb-2 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
          {{ $produto->categoria->nome ?? 'Categoria' }}
        </span>

        {{-- NOME --}}
        <h3 class="text-xl font-semibold text-gray-800">
          {{ \Illuminate\Support\Str::limit($produto->nome, 15) }}
        </h3>

        {{-- DESCRIÇÃO --}}
        <p class="mt-1 text-sm text-gray-600">
          {{ \Illuminate\Support\Str::limit($produto->descricao, 30) }}
        </p>

        {{-- PREÇO --}}
        <p class="mt-3 text-lg font-bold text-green-600">
          R$ {{ number_format($produto->preco, 2, ',', '.') }}
        </p>

        {{-- BOTÕES --}}
        <div class="mt-4 space-y-2">
          <a
            href="{{ route('show.detalhes', $produto->slug) }}"
            class="block w-full rounded-lg bg-green-500 py-2.5 text-center text-sm font-medium text-white transition hover:bg-slate-800"
          >
            Detalhes
          </a>

          <button
            class="w-full rounded-lg bg-blue-500 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
          >
            Comprar
          </button>
        </div>

      </div>

    @endforeach

  </div>
</div>

{{-- PAGINAÇÃO --}}
<div class="mt-8 flex justify-center">
  {{ $produtos->links() }}
</div>

@endsection
