@extends('user.dashboard')

@section('title', 'Detalhes')

@section('dashboard')
@include('user.dashboard-content')
<div class="mx-auto max-w-6xl px-4 py-6">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

        {{-- Imagem --}}
        <div class="flex items-center justify-center">

                  <img 
    src="{{ asset('storage/' . $produto->imagem) }}" 
    alt="{{ $produto->nome }}"
    class="h-full w-full transition-transform duration-500 group-hover:scale-110  max-w-md rounded-2xl object-cover shadow-lg"
/>
        </div>

        {{-- Conteúdo --}}
        <div class="flex flex-col gap-4">

            {{-- Voltar --}}
            <button
                onclick="window.history.back()"
                class="cursor-pointer flex w-fit items-center gap-1 text-sm text-slate-600 hover:text-blue-600 transition"
            >
                <span class="material-symbols-outlined">
arrow_circle_left
</span>
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
                <div class="flex items-center gap-2">
                
                <!-- Botão menos -->
                <button
                    type="button"
                    onclick="changeQty(-1)"
                    class="h-10 w-10 rounded-lg border border-gray-300 bg-white
                        hover:bg-gray-100 active:scale-95 transition text-red-600 text-2xl"
                >
                    −
                </button>

                <!-- Input -->
                <input
                    id="qty"
                    type="number"
                    min="1"
                    value="1"
                    inputmode="numeric"
                  class="
                        h-10 w-20
                        text-center
                        rounded-lg
                        border border-gray-300
                        focus:ring-2 focus:ring-blue-500 focus:outline-none
                        [appearance:textfield]
                        [&::-webkit-inner-spin-button]:appearance-none
                        [&::-webkit-outer-spin-button]:appearance-none
                        "

                    oninput="validateQty()"
                />

                <!-- Botão mais -->
                <button
                    type="button"
                    onclick="changeQty(1)"
                    class="h-10 w-10 rounded-lg border border-gray-300 bg-white text-green-600
                        hover:bg-gray-100 active:scale-95 transition text-2xl"
                >
                    +
                </button>

                </div>


                <script>
                const qtyInput = document.getElementById('qty')

                function changeQty(amount) {
                    let current = parseInt(qtyInput.value) || 1
                    let newValue = current + amount

                    if (newValue < 1) newValue = 1

                    qtyInput.value = newValue
                }

                function validateQty() {
                    let value = parseInt(qtyInput.value)

                    if (isNaN(value) || value < 1) {
                    qtyInput.value = 1
                    }
                }
                </script>

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
