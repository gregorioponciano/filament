@extends('user.dashboard')

@section('title', 'Categorias')

@section('dashboard')
@include('user.dashboard-content')
<div class="p-6">
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

    @foreach ($produtos as $produto)

      <div class="group relative flex flex-col overflow-hidden rounded-xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">

        {{-- IMAGEM COM OLHO --}}
        <div class="relative h-64 overflow-hidden bg-gray-100">
          <img
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            src="{{ asset($produto->imagem) }}"
            alt="{{ $produto->nome }}"
          >

          {{-- Overlay --}}
          <div class="absolute inset-0 bg-black/40 opacity-0 transition group-hover:opacity-100"></div>

          {{-- ÍCONE OLHO --}}
          <a
            href="{{ route('show.detalhes', $produto->slug) }}"
            class="absolute inset-0 flex items-center justify-center opacity-0 transition group-hover:opacity-100"
            title="Ver detalhes"
          >
            <span class="rounded-full bg-white p-3 text-xl shadow hover:bg-gray-100">
              👁
            </span>
          </a>
        </div>

        <div class="flex flex-1 flex-col p-5">
            {{-- CATEGORIA --}}
            <div class="mb-2">
                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                  {{ $produto->categoria->nome ?? 'Geral' }}
                </span>
            </div>

            {{-- NOME --}}
            <h3 class="text-lg font-bold text-gray-900 mb-1">
              {{ \Illuminate\Support\Str::limit($produto->nome, 40) }}
            </h3>

            {{-- DESCRIÇÃO --}}
            <p class="text-sm text-gray-500 mb-4 flex-1">
              {{ \Illuminate\Support\Str::limit($produto->descricao, 60) }}
            </p>

            {{-- PREÇO E AÇÕES --}}
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                <p class="text-xl font-bold text-green-600">
                  R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </p>
                
                <button class="rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-700 transition shadow-sm" title="Adicionar ao Carrinho">
comprar
                </button>
            </div>
        </div>


      </div>

    @endforeach

  </div>
</div>

<div class="mt-8 flex justify-center">
  @if(method_exists($produtos, 'links'))
    {{ $produtos->appends(request()->query())->links() }}
  @endif
</div>

@endsection
