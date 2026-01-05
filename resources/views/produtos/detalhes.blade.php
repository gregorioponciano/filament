@extends('user.dashboard')

@section('title', 'Detalhes')

@section('dashboard')
@include('user.dashboard-content')
<div class="mx-auto max-w-6xl px-4 py-6">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

        {{-- Imagem --}}
        <div class="flex items-center justify-center">
            <img
                src="{{ asset($produto->imagem) }}"
                alt="{{ $produto->nome }}"
                class="w-full max-w-md rounded-2xl object-cover shadow-lg"
            >
        </div>

        {{-- Conteúdo --}}
        <div class="flex flex-col gap-4">

            {{-- Voltar --}}
            <button
                onclick="window.history.back()"
                class="flex w-fit items-center gap-1 text-sm text-slate-600 hover:text-blue-600 transition"
            >
                <i class="material-icons text-base">arrow_back</i>
                Voltar
            </button>

            {{-- Categoria --}}
            <span class="w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
                {{ $produto->categoria->nome ?? 'Categoria' }}
            </span>

            {{-- Nome --}}
            <h1 class="text-2xl font-bold text-slate-800 md:text-3xl">
                {{ $produto->nome }}
            </h1>

            {{-- Preço --}}
            <p class="text-xl font-semibold text-green-600">
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>

            {{-- Descrição curta --}}
            <p class="text-sm text-slate-600">
                {{ $produto->descricao }}
            </p>

            {{-- Formulário --}}
            <form action="" method="post" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf

                <input type="hidden" name="id" value="{{ $produto->id }}">
                <input type="hidden" name="nome" value="{{ $produto->nome }}">
                <input type="hidden" name="price" value="{{ $produto->preco }}">
                <input type="hidden" name="image" value="{{ $produto->imagem }}">

                {{-- Quantidade --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-slate-700">
                        Quantidade
                    </label>
                    <input
                        type="number"
                        name="qnt"
                        value="1"
                        min="1"
                        class="w-24 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
                    >
                </div>

                {{-- Botão --}}
                <button
                    class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 active:scale-[0.98]"
                >
                    Comprar agora
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
