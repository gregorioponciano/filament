@extends('user.dashboard')

@section('title', 'Detalhes')

@section('dashboard')
@include('user.dashboard-content')
<div class="mx-auto max-w-6xl px-4 py-6">
        @if ($mensagem = Session::get('aviso'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-red-500 p-5 text-green-800 shadow-sm">
            <h3 class="text-lg font-semibold">Error</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
    @endif
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
            <a
                href="{{ url('/user') }}"
                class="flex items-center text-blue-300  hover:text-blue-400 transition h-12 w-8"
            >
                <span style="font-size: 32px;" class="material-symbols-outlined">
                    arrow_circle_left
                </span>
            </a>
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
                <input type="hidden" name="slug" value="{{ $produto->slug }}">

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

{{-- Seção de Avaliações (Resumo) --}}
<div class="mx-auto max-w-6xl px-4 py-10">
    <div class="rounded-3xl bg-white p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            
            {{-- Média Geral --}}
            <div class="flex items-center gap-6">
                <div class="flex flex-col items-center justify-center rounded-2xl bg-amber-50 px-6 py-4 text-amber-600">
                    <span class="text-4xl font-bold">{{ number_format($produto->feedbacks->avg('rating') ?? 0, 1) }}</span>
                    <span class="text-xs font-medium uppercase tracking-wide">de 5</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Avaliações dos Clientes</h2>
                    <div class="mt-1 flex items-center gap-2">
                        <div class="flex text-amber-400">
                            @php $rating = round($produto->feedbacks->avg('rating') ?? 0); @endphp
                            @for($i=1; $i<=5; $i++)
                                <span>{{ $i <= $rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">({{ $produto->feedbacks->count() }} avaliações)</span>
                    </div>
                </div>
            </div>

            {{-- Botão de Ação --}}
            <div class="w-full md:w-auto">
                @auth
                    <a href="{{ route('feedback.create', $produto->id) }}" 
                       class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gray-900 px-6 py-3 font-semibold text-white transition hover:bg-gray-800 md:w-auto">
                        <span class="material-symbols-outlined text-amber-400">star</span>
                        Avaliar este produto
                    </a>
                @else
                    <a href="{{ route('show.login') }}" class="text-blue-600 hover:underline font-medium">
                        Faça login para avaliar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- Seção de Comentários --}}
<div class="mx-auto max-w-6xl px-4 py-6">
    <h2 class="mb-6 text-2xl font-bold text-text-primary">
        Comentários {{ $produto->comments->count() }}
    </h2>

    {{-- Formulário de Comentário --}}
    @auth
        <div
            x-data="{ content: '' }"
            class="mb-8 rounded-2xl border border-gray-500 bg-card-primary p-6 shadow-sm"
        >
            <h3 class="mb-4 text-lg font-semibold text-text-primary">
                Deixe seu comentário
            </h3>

            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="commentable_type" value="App\Models\Produto">
                <input type="hidden" name="commentable_id" value="{{ $produto->id }}">

                <textarea
                    name="content"
                    rows="3"
                    x-model="content"
                    placeholder="O que você achou deste produto?"
                    class="w-full resize-none rounded-xl border border-gray-400 bg-gray-50 p-3 text-gray-900 focus:border-button-primary focus:ring focus:ring-button-primary/40"
                    required
                ></textarea>

                <div class="mt-4 flex justify-end">
                    <button
                        type="submit"
                        :disabled="content.trim().length < 3"
                        class="rounded-lg bg-button-secondary px-6 py-2 font-medium text-white transition
                               disabled:cursor-not-allowed disabled:opacity-50
                               hover:bg-hover-secondary"
                    >
                        Enviar Comentário
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="mb-8 rounded-xl border border-blue-100 bg-blue-50 p-6 text-center">
            <p class="text-blue-800">
                <a href="{{ route('show.login') }}" class="font-bold underline hover:text-blue-900">
                    Faça login
                </a>
                para deixar um comentário.
            </p>
        </div>
    @endauth

    {{-- Lista de Comentários --}}
    <div class="space-y-6">
        @forelse($produto->comments as $comment)
            <div
                x-data="{ edit: false, text: '{{ addslashes($comment->content) }}' }"
                class="rounded-2xl border border-gray-500 bg-card-primary p-6 shadow-sm"
            >
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 font-bold text-gray-600">
                            {{ substr($comment->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-primary">
                                {{ $comment->user->name ?? 'Usuário' }}
                            </h4>
                            <span class="text-xs text-text-primary/60">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <div    class="flex items-center justify-end gap-4 w-200">
                    <form method="POST" action="{{ route('comments.vote', $comment->id) }}">
                        @csrf
                        <input type="hidden" name="vote" value="1">

                        <button
                            type="submit"
                            class="flex items-center gap-1 transition
                            {{ $comment->userVote() === 1 ? 'text-blue-600' : 'text-gray-400 hover:text-blue-500' }}"
                        >
                            <span class="material-symbols-outlined">thumb_up</span>
                            <span class="text-sm">{{ $comment->likesCount() }}</span>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('comments.vote', $comment->id) }}">
                        @csrf
                        <input type="hidden" name="vote" value="-1">

                        <button
                            type="submit"
                            class="flex items-center gap-1 transition
                            {{ $comment->userVote() === -1 ? 'text-red-600' : 'text-gray-400 hover:text-red-500' }}"
                        >
                            <span class="material-symbols-outlined">thumb_down</span>
                            <span class="text-sm">{{ $comment->dislikesCount() }}</span>
                        </button>
                    </form>
                    </div>
                    @if(Auth::id() === $comment->user_id)
                    <div class="flex items-center gap-3">
                            <button
                                @click="edit = true"
                                class="text-gray-400 hover:text-blue-500 transition"
                                title="Editar"
                            >
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <form
                                action="{{ route('comments.destroy', $comment->id) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja excluir este comentário?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-gray-400 hover:text-red-500 transition"
                                    title="Excluir"
                                >
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- Visualização --}}
                <p
                    x-show="!edit"
                    class="leading-relaxed text-text-primary/90"
                >
                    {{ $comment->content }}
                </p>

                {{-- Edição --}}
                @if(Auth::id() === $comment->user_id)
                    <form
                        x-show="edit"
                        action="{{ route('comments.update', $comment->id) }}"
                        method="POST"
                        class="space-y-3"
                    >
                        @csrf
                        @method('PUT')

                        <textarea
                            name="content"
                            x-model="text"
                            rows="3"
                            class="w-full resize-none rounded-xl border border-gray-400 p-3 focus:ring focus:ring-blue-400/40"
                            required
                        ></textarea>

                        <div class="flex justify-end gap-3">
                            <button
                                type="button"
                                @click="edit = false"
                                class="text-sm text-gray-500 hover:text-gray-700"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                            >
                                Salvar
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @empty
            <p class="py-8 text-center italic text-text-primary/60">
                Nenhum comentário ainda. Seja o primeiro!
            </p>
        @endforelse
    </div>
</div>
     {{-- Favorites --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    @php
        $favoritos = Auth::check() ? Auth::user()->favorites : collect([]);
    @endphp
 <h2 class="text-2xl font-bold text-gray-800 mb-6">Meus Favoritos </h2>
    @if($favoritos->count() > 0)
        @include('produtos.index', ['produtos' => $favoritos])
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