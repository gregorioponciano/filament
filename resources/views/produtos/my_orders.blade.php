@extends('user.dashboard')
@section('title', 'Meus Pedidos')

@section('dashboard')
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
    {{-- Cabeçalho --}}
    <header class="mb-4 text-center">
        <p class="mx-auto text-gray-500 text-2xl">
            Seus pedidos estão aqui!
        </p>
    </header>
    
    {{-- Topo / Navegação --}}
    <div class="flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 mb-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ url('/user') }}"
            class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">
                arrow_circle_left
            </span>
            Voltar
        </a>
        <a href="#"
           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">         
            ...
        </a>
    </div>
    
    @if(isset($orders) && $orders->count() > 0)
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6 sm:py-3">
                            Pedido #
                        </th>
                        <th class="hidden px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:table-cell sm:px-6 sm:py-3">
                            Data
                        </th>
                        <th class="hidden px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 md:table-cell sm:px-6 sm:py-3">
                            Total
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6 sm:py-3">
                            Status
                        </th>
                        <th class="px-3 py-2 text-right text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6 sm:py-3">
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-3 py-2 text-xs font-medium text-gray-900 sm:px-6 sm:py-4 sm:text-sm">
                                {{ $order->id }}
                            </td>

                            <td class="hidden px-3 py-2 text-xs text-gray-500 sm:table-cell sm:px-6 sm:py-4 sm:text-sm">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="hidden px-3 py-2 text-xs font-semibold text-gray-900 md:table-cell sm:px-6 sm:py-4 sm:text-sm">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>

                            <td class="px-3 py-2 text-xs sm:px-6 sm:py-4 sm:text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                    {{ $order->status == 'concluido' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td class="px-3 py-2 text-right text-xs font-medium sm:px-6 sm:py-4 sm:text-sm">
                                <a href="{{ route('produtos.orders', $order->id) }}"
                                   class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 sm:w-auto sm:px-4 sm:py-2.5 sm:text-sm">
                                    Detalhes
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center rounded-xl border border-gray-100 bg-white px-4 py-16 text-center shadow-sm">
            <span class="material-symbols-outlined mb-4 text-5xl text-gray-300 sm:text-6xl">shopping_bag</span>
            <h3 class="mb-2 text-lg font-medium text-gray-900 sm:text-xl">Você ainda não fez pedidos</h3>
            <p class="mx-auto mb-6 max-w-md text-sm text-gray-500 sm:text-base">Explore nossos produtos e faça sua primeira compra.</p>
            <a href="{{ route('user.dashboard') }}" class="rounded-lg bg-button-primary px-6 py-2.5 font-medium transition hover:bg-hover-primary">
                Ir às compras
            </a>
        </div>
    @endif
</div>

{{-- SEÇÃO DE FAVORITOS --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @php
        $favoritos = Auth::check() ? Auth::user()->favorites()->whereHas('categoria', function ($query) {
            $query->where('ativo', true);
        })->get() : collect([]);
    @endphp

    <h2 class="text-center text-gray-500 text-2xl mb-6">
        Meus Favoritos
    </h2>

    @if($favoritos->count() > 0)
        {{-- CARROSSEL COM CARDS FIXOS --}}
        <div class="relative" id="carrossel-container">
            {{-- Botões de navegação --}}
            <button id="prevBtn" 
                class="absolute -left-3 sm:-left-4 top-1/2 -translate-y-1/2 z-10 bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-lg border border-gray-200 transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                disabled>
                <span class="text-2xl">‹</span>
            </button>

            <button id="nextBtn" 
                class="absolute -right-3 sm:-right-4 top-1/2 -translate-y-1/2 z-10 bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-lg border border-gray-200 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                <span class="text-2xl">›</span>
            </button>

            {{-- Container do carrossel --}}
            <div class="overflow-hidden mx-1">
                <div id="carouselTrack" class="flex gap-4 transition-transform duration-300 ease-out">
                    @foreach ($favoritos as $produto)
                        <div class="carousel-item flex-shrink-0" style="width: 280px;">
                            {{-- CARD FIXO - NÃO USA INCLUDE --}}
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all h-full flex flex-col">
                                {{-- Imagem do produto --}}
                                <div class="aspect-square overflow-hidden rounded-t-xl bg-gray-100">
                                    @if($produto->imagem)
                                        <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                             alt="{{ $produto->nome }}"
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Informações do produto --}}
                                <div class="p-3 flex-1 flex flex-col">
                                    <h3 class="font-semibold text-gray-800 text-sm line-clamp-2 min-h-[40px]">
                                        {{ $produto->nome }}
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2 min-h-[32px]">
                                        {{ $produto->descricao ?? 'Sem descrição' }}
                                    </p>
                                    
                                    <div class="mt-2 flex items-baseline justify-between">
                                        <span class="text-lg font-bold text-blue-600">
                                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </span>
                                        @if($produto->preco_antigo)
                                            <span class="text-xs text-gray-400 line-through">
                                                R$ {{ number_format($produto->preco_antigo, 2, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    {{-- Botão de ação --}}
                                    <button class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded-lg transition-colors">
                                        Ver detalhes
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Indicadores --}}
            <div class="flex justify-center items-center gap-3 mt-6">
                <div class="flex gap-2" id="dots-container">
                    @for($i = 0; $i < $favoritos->count(); $i++)
                        <button class="dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-blue-600 w-6' : 'bg-gray-300 hover:bg-gray-400' }}"
                                data-index="{{ $i }}"></button>
                    @endfor
                </div>
                <span id="slideCounter" class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
                    1/{{ $favoritos->count() }}
                </span>
            </div>
        </div>
    @else
        {{-- Mensagem quando não há favoritos --}}
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">favorite_border</span>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Você ainda não tem favoritos</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">
                Salve os produtos que você mais gosta aqui para encontrá-los facilmente depois.
            </p>
            <a href="{{ route('user.dashboard') }}"
               class="rounded-lg bg-button-primary px-6 py-2.5 font-medium hover:bg-hover-primary transition">
                Explorar produtos
            </a>
        </div>
    @endif
</div>

{{-- CSS para garantir que os cards fiquem perfeitos --}}
<style>
/* Cards com tamanho FIXO em TODAS as telas */
.carousel-item {
    flex: 0 0 280px;
    width: 280px;
}

.carousel-item > div {
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Garantir que as imagens não deformem */
.aspect-square {
    aspect-ratio: 1 / 1;
}

/* Limitar linhas de texto */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mobile: cards um pouco menores mas ainda fixos */
@media (max-width: 640px) {
    .carousel-item {
        flex: 0 0 260px;
        width: 260px;
    }
}

/* Telas muito grandes: mantém o mesmo tamanho */
@media (min-width: 1536px) {
    .carousel-item {
        flex: 0 0 280px;
        width: 280px;
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
</style>

{{-- JavaScript simplificado --}}
<script>
(function() {
    // Elementos
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.dot');
    const counter = document.getElementById('slideCounter');
    
    if (!track || !prevBtn || !nextBtn) return;
    
    // Configuração
    const STEP = 296; // 280px (card) + 16px (gap)
    
    let currentIndex = 0;
    const totalItems = track.children.length;
    
    // Função para calcular quantos cards cabem
    function getItemsPerView() {
        const containerWidth = track.parentElement.offsetWidth;
        if (window.innerWidth < 640) return 1; // Mobile: 1 card
        if (window.innerWidth < 1024) return 2; // Tablet: 2 cards
        if (window.innerWidth < 1280) return 3; // Desktop: 3 cards
        return 4; // Desktop grande: 4 cards
    }
    
    // Função para calcular índice máximo
    function getMaxIndex() {
        return Math.max(0, totalItems - getItemsPerView());
    }
    
    // Função para atualizar tudo
    function updateCarousel() {
        const maxIndex = getMaxIndex();
        
        // Ajustar índice se necessário
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }
        
        // Mover o track
        track.style.transform = `translateX(-${currentIndex * STEP}px)`;
        
        // Atualizar botões
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        
        // Atualizar dots
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('bg-blue-600', 'w-6');
                dot.classList.remove('bg-gray-300', 'hover:bg-gray-400');
            } else {
                dot.classList.remove('bg-blue-600', 'w-6');
                dot.classList.add('bg-gray-300', 'hover:bg-gray-400');
            }
        });
        
        // Atualizar contador
        if (counter) {
            counter.textContent = `${currentIndex + 1}/${totalItems}`;
        }
    }
    
    // Event listeners
    nextBtn.addEventListener('click', function() {
        if (currentIndex < getMaxIndex()) {
            currentIndex++;
            updateCarousel();
        }
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });
    
    dots.forEach((dot) => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            const maxIndex = getMaxIndex();
            if (index <= maxIndex) {
                currentIndex = index;
                updateCarousel();
            }
        });
    });
    
    // Touch para mobile
    let touchStart = 0;
    
    track.addEventListener('touchstart', (e) => {
        touchStart = e.changedTouches[0].screenX;
    }, { passive: true });
    
    track.addEventListener('touchend', (e) => {
        const touchEnd = e.changedTouches[0].screenX;
        const diff = touchStart - touchEnd;
        const maxIndex = getMaxIndex();
        
        if (Math.abs(diff) > 50) {
            if (diff > 0 && currentIndex < maxIndex) {
                currentIndex++;
            } else if (diff < 0 && currentIndex > 0) {
                currentIndex--;
            }
            updateCarousel();
        }
    });
    
    // Resize com debounce
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateCarousel, 150);
    });
    
    // Inicializar
    updateCarousel();
})();
</script>
@endsection