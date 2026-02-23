@extends('user.dashboard')

@section('title', 'Detalhes')

@section('dashboard')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Mensagens de alerta --}}
    @if ($mensagem = Session::get('aviso'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
            <h3 class="text-lg font-semibold">Erro</h3>
            <p class="mt-1 text-sm">{{ $mensagem }}</p>
        </div>
    @endif
    
    @if (session('erro'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm" role="alert">
            {{ session('erro') }}
        </div>
    @endif

    @php
        $url = urlencode(url()->current());
        $titulo = urlencode('Olha isso que encontrei 😍');
    @endphp

    {{-- Topo / Navegação --}}
    <div class="mb-6 flex justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ url('/user') }}"
           class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition-transform group-hover:-translate-x-1">
                arrow_circle_left
            </span>
            Voltar
        </a>

        {{-- Botão Share --}}
        <button 
            type="button"
            onclick="abrirShareModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            <span class="material-symbols-outlined">share</span>
            Compartilhar
        </button>
    </div>

    {{-- MODAL DE COMPARTILHAMENTO REDESIGN --}}
    <div 
        id="shareModal" 
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-md transition-all duration-300"
        onclick="if(event.target === this) fecharShareModal()"
    >
        {{-- Conteúdo do Modal --}}
        <div class="w-full max-w-sm rounded-3xl bg-white shadow-2xl mx-4 transform transition-all duration-300 scale-95 animate-modalIn">
            
            {{-- Cabeçalho com gradiente --}}
            <div class="relative bg-gradient-to-r from-blue-600 to-blue-500 rounded-t-3xl p-6 text-white">
                <button onclick="fecharShareModal()" 
                        class="absolute right-4 top-4 rounded-full bg-white/20 p-2 text-white hover:bg-white/30 transition backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <div class="flex items-center gap-4">
                    <div class="rounded-full bg-white/30 p-3 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Compartilhar</h3>
                        <p class="text-sm text-blue-100">Escolha uma opção abaixo</p>
                    </div>
                </div>
            </div>

            {{-- Corpo do Modal --}}
            <div class="p-6">
                {{-- Ícones de Redes Sociais - Tamanho reduzido --}}
                <div class="grid grid-cols-3 gap-4 mb-6">
                    
                    {{-- WhatsApp Card --}}
                    <a href="https://wa.me/?text={{ $titulo }}%20{{ $url }}"
                       target="_blank"
                       class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-green-50 hover:bg-green-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" 
                                 class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110" 
                                 alt="WhatsApp">
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <span class="text-xs font-semibold text-gray-700">WhatsApp</span>
                        <span class="text-[10px] text-gray-500">Conversar</span>
                    </a>

                    {{-- Facebook Card --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                       target="_blank"
                       class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-blue-50 hover:bg-blue-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" 
                                 class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110" 
                                 alt="Facebook">
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white"></span>
                        </div>
                        <span class="text-xs font-semibold text-gray-700">Facebook</span>
                        <span class="text-[10px] text-gray-500">Compartilhar</span>
                    </a>

                    {{-- Instagram Card --}}
                    <button type="button"
                            onclick="copiarLinkInstagram()"
                            class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 hover:from-purple-100 hover:via-pink-100 hover:to-orange-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" 
                                 class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110" 
                                 alt="Instagram">
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full border-2 border-white"></span>
                        </div>
                        <span class="text-xs font-semibold text-gray-700">Instagram</span>
                        <span class="text-[10px] text-gray-500">Copiar link</span>
                    </button>
                </div>

                {{-- Opção de Copiar Link Direto --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="h-px flex-1 bg-gray-200"></div>
                        <span class="text-xs font-medium text-gray-400">OU</span>
                        <div class="h-px flex-1 bg-gray-200"></div>
                    </div>

                    <div class="relative">
                        <input type="text" 
                               id="linkToCopy" 
                               value="{{ url()->current() }}" 
                               readonly
                               class="w-full px-4 py-3 pr-20 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <button onclick="copiarLinkDireto()"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1 copy-direct-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                            Copiar
                        </button>
                    </div>
                </div>

                {{-- Feedback Visual Animado (inicialmente oculto) --}}
                <div id="copyFeedback" class="hidden">
                    {{-- Toast de sucesso --}}
                    <div class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none">
                        <div id="successToast" 
                             class="bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transform transition-all duration-500 translate-y-0 opacity-100">
                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center animate-bounce">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" id="feedbackMessage">Link copiado com sucesso!</p>
                                <p class="text-xs text-gray-400" id="feedbackSubtext">Agora é só colar no Instagram 📸</p>
                            </div>
                        </div>
                    </div>

                    {{-- Confetti Canvas --}}
                    <canvas id="confettiCanvas" class="fixed inset-0 pointer-events-none z-40"></canvas>
                </div>
            </div>
            
            {{-- Rodapé do Modal --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-3xl border-t border-gray-100">
                <p class="text-xs text-center text-gray-500">
                    🔗 Link compartilhável • 
                    <span class="font-medium text-gray-700">{{ Str::limit(url()->current(), 30) }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Grid principal --}}
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        {{-- Imagem --}}
        <div class="w-full max-w-md mx-auto overflow-hidden rounded-2xl bg-gray-100 shadow-sm">
            <img 
                src="{{ asset('storage/' . $produto->imagem) }}" 
                alt="{{ $produto->nome }}"
                class="w-full h-auto transition-transform duration-500 hover:scale-105"
            />
        </div>

        {{-- Conteúdo do produto --}}
        <div class="flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            
            {{-- Cabeçalho com categoria e favorito --}}
            <div class="mb-4 flex items-center justify-between">
                <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                    {{ $produto->categoria->nome ?? 'Geral' }}
                </span>
                
                <form action="{{ route('favorites.toggle') }}" method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <button type="submit" 
                            class="transition-colors {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                        <span class="material-symbols-outlined text-2xl">favorite</span>
                    </button>
                </form>
            </div>

            {{-- Nome do produto --}}
            <h1 class="mb-2 text-2xl font-bold text-gray-900 md:text-3xl">
                {{ $produto->nome }}
            </h1>

            {{-- Estoque --}}
            <p class="mb-4 text-sm text-gray-500">
                Estoque: {{ $produto->estoque }} unidades
            </p>

            {{-- Preço --}}
            <p class="mb-4 text-3xl font-bold text-gray-900">
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>

            {{-- Descrição --}}
            <p class="mb-6 text-sm text-gray-600 leading-relaxed">
                {{ $produto->descricao }}
            </p>

            {{-- Formulário de compra --}}
            <form action="{{ route('site.addcarrinho') }}" method="post" class="mt-auto">
                @csrf
                <input type="hidden" name="id" value="{{ $produto->id }}">
                <input type="hidden" name="nome" value="{{ $produto->nome }}">
                <input type="hidden" name="preco" value="{{ $produto->preco }}">
                <input type="hidden" name="imagem" value="{{ $produto->imagem }}">
                <input type="hidden" name="slug" value="{{ $produto->slug }}">

                {{-- Controle de quantidade --}}
                <div class="mb-6 flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700">Quantidade:</span>
                    
                    <button type="button" onclick="changeQty(-1)" 
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-2xl text-red-600 hover:bg-gray-100 transition">
                        −
                    </button>
                    
                    <input id="qty" name="estoque" type="number" min="1" value="1" 
                           class="h-10 w-20 rounded-lg border border-gray-300 text-center focus:border-blue-500 focus:ring-1 focus:ring-blue-500 [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                           oninput="validateQty()" />
                    
                    <button type="button" onclick="changeQty(1)" 
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-2xl text-green-600 hover:bg-gray-100 transition">
                        +
                    </button>

                    @if ($quantidadeNoCarrinho > 0)
                        <span class="ml-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                            {{ $quantidadeNoCarrinho }} no carrinho
                        </span>
                    @endif
                </div>

                {{-- Botão de compra --}}
                <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Comprar agora
                </button>
            </form>
        </div>
    </div>

    {{-- Seção de Avaliações --}}
    <div class="mt-10 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
            
            {{-- Média das avaliações --}}
            <div class="flex items-center gap-6">
                <div class="flex flex-col items-center justify-center rounded-xl bg-amber-50 px-5 py-3">
                    <span class="text-3xl font-bold text-amber-600">{{ number_format($produto->feedbacks->avg('rating') ?? 0, 1) }}</span>
                    <span class="text-xs font-medium text-amber-600">de 5</span>
                </div>
                
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Avaliações</h2>
                    <div class="mt-1 flex items-center gap-2">
                        <div class="flex text-amber-400">
                            @php $rating = round($produto->feedbacks->avg('rating') ?? 0); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-lg">{{ $i <= $rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">({{ $produto->feedbacks->count() }} avaliações)</span>
                    </div>
                </div>
            </div>

            {{-- Botão de avaliar --}}
            <div>
                @auth
                    <a href="{{ route('feedback.create', $produto->id) }}" 
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <span class="material-symbols-outlined text-amber-400">star</span>
                        Avaliar produto
                    </a>
                @else
                    <a href="{{ route('show.login') }}" class="text-sm font-medium text-blue-600 hover:underline">
                        Faça login para avaliar
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Seção de Comentários --}}
    <div class="mt-10">
        <h2 class="mb-6 text-2xl font-bold text-gray-900">
            Comentários ({{ $produto->comments->count() }})
        </h2>

        {{-- Formulário de comentário --}}
        @auth
            <div x-data="{ content: '' }" class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Deixe seu comentário</h3>

                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentable_type" value="App\Models\Produto">
                    <input type="hidden" name="commentable_id" value="{{ $produto->id }}">

                    <textarea name="content" rows="3" x-model="content" 
                              class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                              placeholder="O que você achou deste produto?" required></textarea>

                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                                :disabled="content.trim().length < 3"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                            Enviar comentário
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="mb-8 rounded-2xl border border-blue-100 bg-blue-50 p-6 text-center">
                <p class="text-blue-800">
                    <a href="{{ route('show.login') }}" class="font-medium underline hover:text-blue-900">
                        Faça login
                    </a>
                    para deixar um comentário.
                </p>
            </div>
        @endauth

        {{-- Lista de comentários --}}
        <div class="space-y-4">
            @forelse($produto->comments as $comment)
                <div x-data="{ edit: false, text: '{{ addslashes($comment->content) }}' }" 
                     class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    
                    {{-- Cabeçalho do comentário --}}
                    <div class="mb-4 flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 font-bold text-gray-600">
                                {{ substr($comment->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    {{ $comment->user->name ?? 'Usuário' }}
                                </h4>
                                <span class="text-xs text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        {{-- Ações do comentário --}}
                        <div class="flex items-center gap-3">
                            {{-- Likes --}}
                            <form method="POST" action="{{ route('comments.vote', $comment->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                                <button type="submit" 
                                        class="flex items-center gap-1 text-sm transition {{ $comment->userVote() === 1 ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }}">
                                    <span class="material-symbols-outlined text-lg">thumb_up</span>
                                    <span>{{ $comment->likesCount() }}</span>
                                </button>
                            </form>

                            {{-- Dislikes --}}
                            <form method="POST" action="{{ route('comments.vote', $comment->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                                <button type="submit" 
                                        class="flex items-center gap-1 text-sm transition {{ $comment->userVote() === -1 ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                                    <span class="material-symbols-outlined text-lg">thumb_down</span>
                                    <span>{{ $comment->dislikesCount() }}</span>
                                </button>
                            </form>

                            {{-- Delete --}}
                            @if(Auth::id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                      onsubmit="return confirm('Deseja excluir este comentário?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 transition hover:text-red-600">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Conteúdo do comentário --}}
                    <div x-show="!edit" 
                         @if(Auth::id() === $comment->user_id) @click="edit = true" @endif
                         class="cursor-pointer text-gray-700 {{ Auth::id() === $comment->user_id ? 'hover:bg-gray-50 p-2 -m-2 rounded-lg' : '' }}">
                        <p class="whitespace-pre-wrap">{{ $comment->content }}</p>
                    </div>

                    {{-- Edição --}}
                    @if(Auth::id() === $comment->user_id)
                        <form x-show="edit" x-transition 
                              action="{{ route('comments.update', $comment->id) }}" method="POST"
                              class="mt-4 space-y-3">
                            @csrf
                            @method('PUT')

                            <textarea name="content" x-model="text" rows="3" 
                                      class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>

                            <div class="flex justify-end gap-3">
                                <button type="button" @click="edit = false"
                                        class="text-sm font-medium text-gray-500 transition hover:text-gray-700">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                    Salvar
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @empty
                <p class="rounded-2xl border border-gray-200 bg-white p-8 text-center text-gray-500">
                    Nenhum comentário ainda. Seja o primeiro!
                </p>
            @endforelse
        </div>
    </div>

    {{-- SEÇÃO DE FAVORITOS - CARROSSEL COMPACTO --}}
    <div class="mt-16">
        @php
            $favoritos = Auth::check() ? Auth::user()->favorites()->whereHas('categoria', function ($query) {
                $query->where('ativo', true);
            })->get() : collect([]);
        @endphp

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Meus Favoritos
            </h2>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ $favoritos->count() }} itens
            </span>
        </div>

        @if($favoritos->count() > 0)
            {{-- CARROSSEL SIMPLIFICADO --}}
            <div x-data="carrosselFavoritos()" x-init="init()" class="relative">
                
                {{-- Botões de navegação --}}
                <template x-if="totalSlides > slidesPorView">
                    <button @click="prev" 
                            x-show="indiceAtual > 0"
                            class="absolute -left-3 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-md border border-gray-200 hover:shadow-lg transition-all">
                        <span class="text-xl">‹</span>
                    </button>
                </template>

                <template x-if="totalSlides > slidesPorView">
                    <button @click="next" 
                            x-show="indiceAtual < totalSlides - slidesPorView"
                            class="absolute -right-3 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-md border border-gray-200 hover:shadow-lg transition-all">
                        <span class="text-xl">›</span>
                    </button>
                </template>

                {{-- Container do carrossel --}}
                <div class="overflow-hidden px-1">
                    <div class="flex gap-3 transition-transform duration-300 ease-out" 
                         :style="`transform: translateX(-${posicaoScroll}px)`">
                        
                        @foreach ($favoritos as $produto)
                            <div class="flex-shrink-0 w-[180px] sm:w-[200px] md:w-[220px]">
                                {{-- CARD COMPACTO --}}
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all h-full flex flex-col">
                                    
                                    {{-- Imagem --}}
                                    <div class="aspect-square w-full bg-gray-100">
                                        @if($produto->imagem)
                                            <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                                 alt="{{ $produto->nome }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                <span class="material-symbols-outlined text-3xl text-gray-400">image</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="p-2 flex flex-col flex-1">
                                        {{-- Categoria --}}
                                        <span class="text-xs text-blue-600 font-medium mb-1 truncate">
                                            {{ $produto->categoria->nome ?? 'Geral' }}
                                        </span>
                                        
                                        {{-- Nome --}}
                                        <h3 class="font-medium text-gray-800 text-xs sm:text-sm line-clamp-2 min-h-[32px] mb-1">
                                            {{ $produto->nome }}
                                        </h3>
                                        
                                        {{-- Preço --}}
                                        <p class="text-sm sm:text-base font-bold text-gray-900 mb-2">
                                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </p>
                                        
                                        {{-- Ações --}}
                                        <div class="flex gap-1 mt-auto">
                                            <a href="{{ route('show.detalhes', $produto->slug) }}" 
                                               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium py-1.5 px-2 rounded text-center transition">
                                                Ver
                                            </a>
                                            <form action="{{ route('favorites.toggle') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                                <button type="submit"
                                                        class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-1.5 px-2 rounded transition"
                                                        onclick="return confirm('Remover dos favoritos?')">
                                                    <span class="material-symbols-outlined text-base">favorite</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Paginação compacta --}}
                <div class="flex items-center justify-center gap-3 mt-4">
                    <div class="flex gap-1.5">
                        <template x-for="(_, index) in Array.from({ length: totalSlides - slidesPorView + 1 })" :key="index">
                            <button @click="irPara(index)" 
                                    class="h-2 rounded-full transition-all duration-300"
                                    :class="indiceAtual === index ? 'w-5 bg-blue-600' : 'w-2 bg-gray-300 hover:bg-gray-400'"></button>
                        </template>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full" 
                          x-text="`${indiceAtual + 1}/${totalSlides - slidesPorView + 1}`"></span>
                </div>
            </div>
        @else
            {{-- Mensagem sem favoritos --}}
            <div class="flex flex-col items-center justify-center rounded-2xl border border-gray-200 bg-white p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300">favorite_border</span>
                <h3 class="mt-3 text-lg font-medium text-gray-900">Nenhum favorito ainda</h3>
                <p class="mt-1 text-sm text-gray-500">Comece a explorar e salve seus produtos preferidos</p>
                <a href="{{ route('user.dashboard') }}" 
                   class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                    Explorar produtos
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Scripts JavaScript --}}
<script>
// ============================================
// CONFIGURAÇÕES DO MODAL DE COMPARTILHAMENTO
// ============================================

// Variáveis globais
let confettiInterval;

// Funções do Modal
function abrirShareModal() {
    const modal = document.getElementById('shareModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('flex');
    }, 10);
}

function fecharShareModal() {
    const modal = document.getElementById('shareModal');
    const modalContent = modal.querySelector('.transform');
    
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalContent.classList.remove('scale-95', 'opacity-0');
    }, 300);
}

// Função principal para copiar link do Instagram
function copiarLinkInstagram() {
    const link = "{{ url()->current() }}";
    
    navigator.clipboard.writeText(link).then(() => {
        fecharShareModal();
        mostrarFeedbackCompleto('Instagram', link);
    }).catch(err => {
        console.error('Erro ao copiar:', err);
        alert('Não foi possível copiar o link. Tente novamente.');
    });
}

// Função para copiar link direto do input
function copiarLinkDireto() {
    const linkInput = document.getElementById('linkToCopy');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(linkInput.value).then(() => {
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copiado!';
        btn.classList.add('bg-green-600');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('bg-green-600');
        }, 2000);
        
        mostrarFeedbackSimples('Link copiado!');
    });
}

// Feedback completo com animações e confetti
function mostrarFeedbackCompleto(rede, link) {
    const feedback = document.getElementById('copyFeedback');
    const toast = document.getElementById('successToast');
    const message = document.getElementById('feedbackMessage');
    const subtext = document.getElementById('feedbackSubtext');
    
    message.textContent = `Link copiado para ${rede}!`;
    subtext.textContent = 'Agora é só colar e compartilhar 📱';
    
    feedback.classList.remove('hidden');
    iniciarConfetti();
    
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            feedback.classList.add('hidden');
            toast.classList.remove('translate-y-full', 'opacity-0');
            pararConfetti();
        }, 500);
    }, 3000);
}

// Feedback simples (apenas toast)
function mostrarFeedbackSimples(mensagem) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-2 animate-slideUp';
    toast.innerHTML = `
        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-sm font-medium">${mensagem}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('animate-slideDown');
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Sistema de Confetti
function iniciarConfetti() {
    const canvas = document.getElementById('confettiCanvas');
    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    
    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    }
    
    function createParticles() {
        for (let i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height - height,
                size: Math.random() * 5 + 2,
                speedY: Math.random() * 3 + 2,
                speedX: Math.random() * 2 - 1,
                color: `hsl(${Math.random() * 360}, 70%, 60%)`
            });
        }
    }
    
    function animate() {
        ctx.clearRect(0, 0, width, height);
        
        particles.forEach((p, index) => {
            p.y += p.speedY;
            p.x += p.speedX;
            
            ctx.fillStyle = p.color;
            ctx.fillRect(p.x, p.y, p.size, p.size);
            
            if (p.y > height) {
                particles.splice(index, 1);
            }
        });
        
        if (particles.length < 30) {
            for (let i = 0; i < 5; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: -10,
                    size: Math.random() * 5 + 2,
                    speedY: Math.random() * 3 + 2,
                    speedX: Math.random() * 2 - 1,
                    color: `hsl(${Math.random() * 360}, 70%, 60%)`
                });
            }
        }
        
        confettiInterval = requestAnimationFrame(animate);
    }
    
    resize();
    createParticles();
    animate();
    
    window.addEventListener('resize', resize);
}

function pararConfetti() {
    if (confettiInterval) {
        cancelAnimationFrame(confettiInterval);
        confettiInterval = null;
        
        const canvas = document.getElementById('confettiCanvas');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
}

// ============================================
// FUNÇÕES DO CONTADOR DE QUANTIDADE
// ============================================

const qtyInput = document.getElementById('qty');

function changeQty(amount) {
    let current = parseInt(qtyInput.value) || 1;
    let newValue = current + amount;
    if (newValue < 1) newValue = 1;
    qtyInput.value = newValue;
}

function validateQty() {
    let value = parseInt(qtyInput.value);
    if (isNaN(value) || value < 1) {
        qtyInput.value = 1;
    }
}

// ============================================
// CARROSSEL DE FAVORITOS
// ============================================

function carrosselFavoritos() {
    return {
        indiceAtual: 0,
        posicaoScroll: 0,
        slidesPorView: 4,
        totalSlides: {{ $favoritos->count() }},
        
        init() {
            this.calcularSlidesPorView();
            window.addEventListener('resize', () => {
                this.calcularSlidesPorView();
                this.irPara(0);
            });
        },
        
        calcularSlidesPorView() {
            if (window.innerWidth < 480) {
                this.slidesPorView = 2;
            } else if (window.innerWidth < 640) {
                this.slidesPorView = 2.5;
            } else if (window.innerWidth < 768) {
                this.slidesPorView = 3;
            } else if (window.innerWidth < 1024) {
                this.slidesPorView = 4;
            } else {
                this.slidesPorView = 5;
            }
        },
        
        get larguraCard() {
            if (window.innerWidth < 480) return 186;
            if (window.innerWidth < 640) return 156;
            if (window.innerWidth < 768) return 176;
            return 226;
        },
        
        next() {
            if (this.indiceAtual < this.totalSlides - Math.floor(this.slidesPorView)) {
                this.indiceAtual++;
                this.posicaoScroll = this.indiceAtual * this.larguraCard;
            }
        },
        
        prev() {
            if (this.indiceAtual > 0) {
                this.indiceAtual--;
                this.posicaoScroll = this.indiceAtual * this.larguraCard;
            }
        },
        
        irPara(index) {
            this.indiceAtual = index;
            this.posicaoScroll = index * this.larguraCard;
        }
    }
}
</script>

{{-- Estilos CSS --}}
<style>
/* Utilitários */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animações do Modal */
@keyframes modalIn {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.animate-modalIn {
    animation: modalIn 0.3s ease-out forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translate(-50%, 100%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, 0);
    }
}

.animate-slideUp {
    animation: slideUp 0.3s ease-out forwards;
}

@keyframes slideDown {
    from {
        opacity: 1;
        transform: translate(-50%, 0);
    }
    to {
        opacity: 0;
        transform: translate(-50%, 100%);
    }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out forwards;
}

/* Ajustes mobile */
@media (max-width: 480px) {
    .favorito-card {
        width: 180px;
    }
}

/* Esconder scrollbar */
.overflow-hidden {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.overflow-hidden::-webkit-scrollbar {
    display: none;
}

/* Botão de cópia animado */
.copy-direct-btn {
    transition: all 0.2s ease;
}

.copy-direct-btn.bg-green-600 {
    background-color: #059669;
}

/* Toast de feedback */
#successToast {
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

#successToast.translate-y-full {
    transform: translateY(100%);
    opacity: 0;
}
</style>
@endsection