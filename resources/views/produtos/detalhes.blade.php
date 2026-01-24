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
        <div class="flex flex-col gap-4 border border-border-primary  rounded-2xl p-4">

            {{-- Voltar --}}
            <button
                onclick="window.history.back()"
                class="cursor-pointer flex w-fit items-center gap-1 text-sm text-blue-300 hover:text-blue-400 transition"
            >
                <span class="material-symbols-outlined

">
arrow_circle_left
</span>
            </button>

            {{-- Categoria --}}
            <div class="mb-2 flex items-center justify-between">
                <span class="w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
                    {{ $produto->categoria->nome ?? 'Categoria' }}
                </span>
                <form action="{{ route('favorites.toggle') }}" method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <button type="submit" class="cursor-pointer transition-colors {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                        <span class="material-symbols-outlined">favorite</span>
                    </button>
                </form>
            </div>

            {{-- Nome --}}
            <h1 class="text-2xl font-bold text-text-primary md:text-3xl">
                {{ $produto->nome }}
            </h1>

            {{-- Preço --}}
            <p class="text-xl font-semibold text-text-price">
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>

            {{-- Descrição curta --}}
            <p class="text-sm text-slate-600">
                {{ $produto->descricao }}
            </p>

            {{-- Formulário --}}
            <form action="{{ route('site.addcarrinho') }}" method="post" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf

                <input type="hidden" name="id" value="{{ $produto->id }}">
                <input type="hidden" name="nome" value="{{ $produto->nome }}">
                <input type="hidden" name="preco" value="{{ $produto->preco }}">
                <input type="hidden" name="imagem" value="{{ $produto->imagem }}">

                {{-- Quantidade --}}
                <div class="flex items-center gap-2">
                
                <!-- Botão menos -->
                <button type="button" onclick="changeQty(-1)" class="h-10 w-10 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 active:scale-95 transition text-red-600 text-2xl">
                    −
                </button>
                <!-- Input -->
                <input id="qty" name="estoque" type="number" min="1" value="1" inputmode="numeric"class="
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
                    class="w-full rounded-xl bg-button-primary py-4 font-semibold transition hover:bg-hover-primary"
                >
                    Comprar agora
                </button>
            </form>

        </div>
    </div>
</div>

    {{-- Seção de Comentários --}}
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-text-primary mb-6">Comentários</h2>

        {{-- Formulário de Comentário --}}
        @auth
            <div class="bg-card-primary rounded-2xl shadow-sm border border-gray-500 p-6 mb-8">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Deixe seu comentário</h3>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentable_type" value="App\Models\Produto">
                    <input type="hidden" name="commentable_id" value="{{ $produto->id }}">

                    <div class="mb-4">
                        <textarea 
                            name="content" 
                            rows="3" 
                            class="w-full rounded-xl border-gray-500 bg-gray-50 text-gray-900 shadow-sm focus:border-button-primary focus:ring focus:ring-button-primary focus:ring-opacity-50 p-3"
                            placeholder="O que você achou deste produto?"
                            required
                        ></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-button-secondary px-6 py-2 text-white transition hover:bg-hover-secondary font-medium">
                            Enviar Comentário
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-blue-50 rounded-xl p-6 mb-8 text-center border border-blue-100">
                <p class="text-blue-800">
                    <a href="{{ route('show.login') }}" class="font-bold underline hover:text-blue-900">Faça login</a> para deixar um comentário.
                </p>
            </div>
        @endauth

        {{-- Lista de Comentários --}}
        <div class="space-y-6">
            @forelse($produto->comments as $comment)
                <div class="bg-card-primary rounded-2xl shadow-sm border border-gray-500 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-lg">
                                {{ substr($comment->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-text-primary">{{ $comment->user->name ?? 'Usuário' }}</h4>
                                <span class="text-xs text-text-primary opacity-60">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-text-primary opacity-90 leading-relaxed">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-text-primary opacity-60 text-center py-8 italic">Nenhum comentário ainda. Seja o primeiro!</p>
            @endforelse
        </div>
    </div>
</div>

@endsection