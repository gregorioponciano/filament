@php
$icones = [
    'camisetas' => 'apparel',
    'blusas' => 'apparel',
    'bone' => 'child_hat',
    'casacos' => 'apparel',
    'shorts' => 'steps',
];
$cartCount = isset($itens) ? $itens->sum('quantity') : 0;
@endphp
<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">

            <div id="mobileMenuBtn" class="flex items-center gap-3 shrink-0 cursor-pointer md:cursor-default">
                <img src="{{ asset('storage/' . ($customizations->imagem ?? 'logo.png')) }}"
                     alt="{{ $customizations->nome ?? 'Logo' }}"
                     class="w-30 h-auto hover:scale-125 object-cover transition">
            </div>

            <a href="{{ route('show.carrinho') }}"
               class="bg-blue-600 rounded-full h-12 w-12 flex items-center justify-center text-white fixed bottom-10 right-5 cursor-pointer hover:bg-blue-700 transition z-50 no-ripple"
               x-data="cartPoller()" x-init="init()">
                <span class="material-symbols-outlined">shopping_cart</span>
                <p class="fixed bottom-18 right-3 bg-blue-600 rounded-full h-8 w-8 flex items-center justify-center text-white text-sm font-bold"
                   x-text="count">{{ $cartCount }}</p>
            </a>

            <div class="flex flex-1 items-center gap-2 w-full md:max-w-2xl">
                <div class="relative">
                    <div class="hidden md:flex items-center whitespace-nowrap" id="categorias">
                        <a href="{{ route('user.dashboard') }}"
                           class="flex items-center px-4 text-xl text-gray-700 hover:text-blue-600 transition-colors">
                            <span class="material-symbols-outlined">home</span> Inicio
                        </a>
                        <button class="active:text-blue-500 h-10">
                            <svg id="categoryBtn" class="size-6 cursor-pointer h-10" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div id="categoryDropdown"
                         class="hidden fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-white shadow-2xl z-50 overflow-y-auto md:absolute md:h-auto md:top-full md:mt-2 md:w-56 md:rounded-xl md:shadow-lg md:ring-1 md:ring-black/5 transition-all duration-300 ease-out origin-top-left -translate-x-full opacity-0 md:translate-x-0 md:opacity-0 md:scale-95 md:-translate-y-2">
                        <div class="max-h-100 overflow-y-auto py-2">
                            <hr class="md:hidden mb-3">
                            <a href="{{ route('user.dashboard') }}"
                               class="flex items-center gap-8 px-2 py-2 m-2 rounded-xl text-gray-700 hover:bg-hover-primary transition md:hidden">
                                <span class="material-symbols-outlined">home</span> Inicio
                            </a>
                            <a href="{{ route('favorites.index') }}"
                               class="flex items-center gap-8 px-2 py-2 m-2 rounded-xl text-gray-700 hover:bg-hover-primary transition">
                                <span class="material-symbols-outlined">favorite</span> Favoritos
                            </a>
                            @foreach ($categorias ?? [] as $categoria)
                                <a href="{{ route('show.categorias', $categoria->slug) }}"
                                   class="flex items-center gap-8 px-2 py-2 m-2 rounded-xl text-gray-700 hover:bg-hover-primary transition">
                                    <span class="material-symbols-outlined">{{ $icones[$categoria->slug] ?? $categoria->icone ?? 'category' }}</span>
                                    {{ $categoria->nome }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form action="{{ route('search') }}" method="GET" class="flex flex-1 items-center gap-2 w-full" id="searchForm">
                    @csrf
                    <input type="search" name="search" value="{{ old('search', $search ?? '') }}"
                           placeholder="Buscar produtos..."
                           class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                           required min="2">
                    <button type="submit"
                            class="flex items-center justify-center rounded-xl bg-blue-600 px-3 py-2 text-white text-sm hover:bg-blue-700 transition shrink-0">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>

                <div class="relative shrink-0">
                    <button id="userBtn"
                            class="flex items-center gap-2 rounded-full bg-white border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="hidden md:block">{{ Auth::user()->name ?? 'admin' }}</p>
                        <svg class="size-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div id="userDropdown"
                         class="hidden absolute right-0 mt-2 w-64 rounded-xl bg-white shadow-lg ring-1 ring-black/5 z-50 transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] origin-top-right opacity-0 scale-90 translate-y-4">
                        <div class="px-4 py-3 border-b flex items-center gap-2">
                            <span class="material-symbols-outlined">person</span>
                            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'admin' }}</p>
                        </div>
                        <div>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <span class="material-symbols-outlined">delivery_truck_speed</span> Pedidos
                            </a>
                            <a href="{{ route('show.profile') }}" class="flex items-center gap-3 px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <span class="material-symbols-outlined">settings</span> Configurações
                            </a>
                            <a href="{{ route('show.suporte') }}" class="flex items-center gap-3 px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <span class="material-symbols-outlined">group</span> Suporte
                            </a>
                        </div>
                        <div class="m-2 border-t pt-2">
                            <form action="{{ route('store.logout') }}" method="POST">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-xl transition cursor-pointer">Sair</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
