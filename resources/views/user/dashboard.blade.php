@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')


<section class=" bg-bg">
    <header class="bg-primary shadow-sm bg-white sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                {{-- Logo --}}
                <div id="mobileMenuBtn" class="flex items-center gap-3 shrink-0 cursor-pointer md:cursor-default">
                    <img src="{{ asset('image/logo.webp') }}" alt="logo" class="w-30 hover:scale-120 transition">
                </div>

                {{-- Search & Categories --}}
                <div class="flex flex-1 items-center gap-4 max-w-2xl">
                    {{-- Category Dropdown --}}
                    <div class="relative">
                        <button id="categoryBtn" class="hidden md:flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-secondary whitespace-nowrap">
                            Categorias
                            <svg class="size-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div id="categoryDropdown" class="hidden fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-white shadow-2xl z-50 overflow-y-auto md:absolute md:h-auto md:top-full md:mt-2 md:w-56 md:rounded-xl md:shadow-lg md:ring-1 md:ring-black/5 transition-all duration-300 ease-out origin-top-left -translate-x-full opacity-0 md:translate-x-0 md:opacity-0 md:scale-95 md:-translate-y-2">
                            <div class="max-h-60 overflow-y-auto py-2">

                                <a href="{{ Route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-hover hover:text-text hover:scale-75 transition">Inicio</a>
                                <hr>
                                @foreach ($categorias as $categoria)
                                    <a href="{{ route('show.categorias', $categoria->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-hover hover:text-text hover:scale-75 transition"> {{ $categoria->nome }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 1 1 1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Buscar produtos..." class="block w-full rounded-xl border-0 bg-gray-100 py-2 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="relative shrink-0">
                    <button id="userBtn" class="flex items-center gap-2 rounded-full bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-secondary">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="hidden md:block text">{{ auth()->user()->name ?? 'admin' }}</p>
                        <svg class="size-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    {{-- Menu --}}
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 rounded-xl bg-white shadow-lg ring-1 ring-black/5 z-50 transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] origin-top-right opacity-0 scale-90 translate-y-4">
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name ?? 'admin' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@demo.com' }}</p>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('show.profile') }}" class="block px-4 py-2 text-sm hover:bg-hover hover:text-text">Perfil</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-hover hover:text-text">Suporte</a>
                        </div>

                        <div class="border-t px-0 py-1">
                            <form action="{{ route('store.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-hover hover:text-text">Sair</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    @yield('dashboard')
    @if(request()->routeIs('user.dashboard'))
        @include('produtos.index')
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const openDropdown = (el) => {
        el.classList.remove('hidden');
        void el.offsetWidth; 

        if (el.id === 'categoryDropdown') {
            if (window.innerWidth < 768) {
                // Mobile: Slide from left
                el.classList.remove('-translate-x-full', 'opacity-0');
                el.classList.add('translate-x-0', 'opacity-100');
            } else {
                // Desktop: Fade down
                el.classList.remove('opacity-0', 'scale-95', '-translate-y-2', 'md:opacity-0', 'md:scale-95', 'md:-translate-y-2');
                el.classList.add('opacity-100', 'scale-100', 'translate-y-0');
            }
        } else if (el.id === 'userDropdown') {
            // User: Fancy pop
            el.classList.remove('opacity-0', 'scale-90', 'translate-y-4');
            el.classList.add('opacity-100', 'scale-100', 'translate-y-0');
        }
    };

    const closeDropdown = (el) => {
        if (el.classList.contains('hidden')) return;
        
        if (el.id === 'categoryDropdown' && window.innerWidth < 768) {
            el.classList.remove('translate-x-0', 'opacity-100');
            el.classList.add('-translate-x-full', 'opacity-0');
        } else if (el.id === 'userDropdown') {
            el.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            el.classList.add('opacity-0', 'scale-90', 'translate-y-4');
        } else {
            el.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            el.classList.add('opacity-0', 'scale-95', '-translate-y-2', 'md:opacity-0', 'md:scale-95', 'md:-translate-y-2');
        }
        
        setTimeout(() => {
            if (el.classList.contains('opacity-0')) {
                el.classList.add('hidden');
            }
        }, 300);
    };

    const toggleDropdown = (btnId, dropdownId, mobileOnly = false) => {
        const btn = document.getElementById(btnId);
        const dropdown = document.getElementById(dropdownId);
        
        if(!btn || !dropdown) return;

        btn.addEventListener('click', (e) => {
            if (mobileOnly && window.innerWidth >= 768) {
                return;
            }

            e.stopPropagation();
            document.querySelectorAll('[id$="Dropdown"]').forEach(el => {
                if(el.id !== dropdownId) closeDropdown(el);
            });
            if (dropdown.classList.contains('hidden')) {
                openDropdown(dropdown);
            } else {
                closeDropdown(dropdown);
            }
        });
    };

    toggleDropdown('categoryBtn', 'categoryDropdown');
    toggleDropdown('userBtn', 'userDropdown');
    toggleDropdown('mobileMenuBtn', 'categoryDropdown', true);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            const catDropdown = document.getElementById('categoryDropdown');
            if (!catDropdown.classList.contains('hidden')) closeDropdown(catDropdown);
        }
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('[id$="Dropdown"]') && !e.target.closest('button[id$="Btn"]')) {
            document.querySelectorAll('[id$="Dropdown"]').forEach(el => closeDropdown(el));
        }
        
    });
});
</script>
@endsection
