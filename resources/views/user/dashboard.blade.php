@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<section class="box-border">
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">

                {{-- Logo --}}
                <div id="mobileMenuBtn" class="flex items-center gap-3 shrink-0 cursor-pointer md:cursor-default">
                    <img 
                        src="{{ asset('storage/' . $customizations->imagem) }}" 
                        alt="{{ $customizations->nome }}"
                        class="w-30 h-auto hover:scale-125 object-cover transition duration-300 group-hover:scale-110"
                    />
                </div> 

                {{-- Search & Categories --}}
                <div class="flex flex-1 items-center gap-2 w-full md:max-w-2xl">
                <div class="relative">

                {{-- BOTÃO DESKTOP --}}
                <div class="hidden md:flex items-center transition-all whitespace-nowrap">

                    <a href="{{ Route('user.dashboard') }}"
                    class="flex items-center px-4 text-xl text-gray-700 hover:text-blue-600 transition-colors">
                        <span class="material-symbols-outlined">home</span>
                        Inicio
                    </a>

                    <button class="active:text-blue-500 h-10 transition-colors hover:text-blue-600">
                        <svg id="categoryBtn" class="size-6 cursor-pointer h-10" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

            {{-- DROPDOWN --}}
                <div id="categoryDropdown"
                class="hidden fixed left-0 top-16 h-[calc(100vh-4rem)] w-64
                    bg-white shadow-2xl z-50 overflow-y-auto
                    md:absolute md:h-auto md:top-full md:mt-2 md:w-56
                    md:rounded-xl md:shadow-lg md:ring-1 md:ring-black/5
                    transition-all duration-300 ease-out
                    origin-top-left
                    -translate-x-full opacity-0
                    md:translate-x-0 md:opacity-0 md:scale-95 md:-translate-y-2">

                <div class="max-h-100 overflow-y-auto py-2">

                <hr class="md:hidden mb-3">
                    {{-- INÍCIO → SOMENTE MOBILE --}}
                <a href="{{ Route('user.dashboard') }}"
                class="flex items-center gap-8 px-2 py-2 m-2 rounded-xl text-gray-700
                        hover:bg-hover-primary transition
                        md:hidden">
                    <span class="material-symbols-outlined">home</span>
                    Inicio
                </a>


                <a href="{{ Route('favorites.index') }}"
                class="flex items-center gap-8  px-2 py-2 m-2 rounded-xl text-gray-700 hover:bg-hover-primary transition">
                    <span class="material-symbols-outlined">favorite</span>
                    Favoritos
                </a>

@php
$icones = [
    'camisetas' => 'apparel',
    'blusas' => 'apparel',
    'bone' => 'child_hat',
    'casacos' => 'apparel',
    'shorts' => 'steps',
];
@endphp

                @foreach ($categorias as $categoria)
                <a href="{{ route('show.categorias', $categoria->slug) }}"
                class="flex items-center gap-8 px-2 py-2 m-2 rounded-xl text-gray-700 hover:bg-hover-primary  transition-200">
                    <span class="material-symbols-outlined">
                        {{ $icones[$categoria->slug] ?? $categoria->icone ?? 'category' }}
                    </span>
                    {{ $categoria->nome }}
                </a>
                @endforeach
                </div>
            </div>
        </div>

                    <form
                    action="{{ route('search') }}"
                    method="GET"
                    class="flex flex-1 items-center gap-2 w-full"
                    id="searchForm"
                    >
                    @csrf
                    <input
                        type="search"
                        name="search"
                        value="{{ old('search', $search ?? '') }}"
                        placeholder="Buscar produtos..."
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        required
                        min="2"
                    >

                    <button
                        type="submit"
                        class="flex items-center justify-center rounded-xl bg-blue-600
                            px-3 py-2 text-white text-sm hover:bg-blue-700 transition shrink-0"
                    >

                        <svg class="h-5 w-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    </form>
                    

                    {{-- Notification Bell --}}
                    <div class="hidden md:block relative shrink-0" x-data="notificationBell()">
                        <button @click="toggle()" class="relative flex items-center justify-center rounded-full bg-white border border-gray-200 h-10 w-10 text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
                            <span class="material-symbols-outlined text-lg">notifications</span>
                            <template x-if="count > 0">
                                <span x-text="count" class="absolute -top-1 -right-1 flex items-center justify-center h-5 min-w-[20px] rounded-full bg-red-500 text-[10px] font-bold text-white px-1 shadow-sm"></span>
                            </template>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-80 rounded-xl bg-white shadow-lg ring-1 ring-black/5 z-50 overflow-hidden">
                            <div class="p-3 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">Notificações</span>
                                <a href="{{ route('notifications.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todas</a>
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                <template x-if="items.length === 0">
                                    <div class="p-6 text-center text-sm text-gray-500">Nenhuma notificação</div>
                                </template>
                                <template x-for="item in items" :key="item.id">
                                    <a :href="item.action_url || '#'"
                                       class="flex items-start gap-3 p-3 hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg"
                                             :style="`background-color: ${bgColor(item.color)}`">
                                            <span class="material-symbols-outlined text-base" :style="`color: ${fgColor(item.color)}`" x-text="item.icon"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate" x-text="item.title"></p>
                                            <p class="text-xs text-gray-500 truncate" x-text="item.message || ''"></p>
                                            <p class="text-[10px] text-gray-400 mt-0.5" x-text="timeAgo(item.created_at)"></p>
                                        </div>
                                        <template x-if="!item.read">
                                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                                        </template>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="relative shrink-0">
                    <button id="userBtn" class="flex items-center gap-2 rounded-full bg-white border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="hidden md:block text">{{ Auth::user()->name ?? 'admin' }}</p>
                        <svg class="size-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    {{-- Menu --}}
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 rounded-xl bg-white shadow-lg ring-1 ring-black/5 z-50 transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] origin-top-right opacity-0 scale-90 translate-y-4">
                        <div class="px-4 py-3 border-b flex items-center">
                            <span class="material-symbols-outlined">
                            person
                            </span>
                            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'admin' }}</p>
                        </div>

                        <div class="">
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <span class="material-symbols-outlined">delivery_truck_speed</span>
                                <p>Pedidos</p>
                            </a>
                            <a href="{{ route('show.profile') }}" class="flex items-center px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <p>Configurações</p></a>
                            <a href="{{ route('notifications.index') }}" x-data="notificationBell()" class="flex items-center px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition relative md:hidden">
                                <span class="material-symbols-outlined">
                                notifications
                                </span>
                                <p>Notificações</p>
                                <template x-if="count > 0">
                                    <span x-text="count" class="ml-auto flex items-center justify-center h-5 min-w-[20px] rounded-full bg-red-500 text-[10px] font-bold text-white px-1 shadow-sm"></span>
                                </template>
                            </a>
                            <a href="{{ route('show.suporte') }}" class="flex items-center px-4 py-2 m-2 text-sm hover:bg-hover-primary rounded-xl transition">
                                <span class="material-symbols-outlined">
                                group
                                </span>
                                Suporte</a>
                        </div>

                            <div class="m-2 flex items-center justify-baseline">
                                <form action="{{ route('store.logout') }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 w-50 cursor-pointer  hover:text-hover-primary text-left transition">
                                        Sair
                                    </button>

                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Cart Button --}}
    <a href="{{ route('show.carrinho') }}"
       class="bg-blue-600 rounded-full h-14 w-14 flex items-center justify-center text-white fixed bottom-6 right-6 cursor-pointer hover:bg-blue-700 transition-all duration-300 hover:scale-110 hover:shadow-xl z-50 shadow-lg">
        <span class="material-symbols-outlined text-2xl">shopping_cart</span>
        @if($itens->sum('quantity') > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 rounded-full h-6 min-w-[24px] flex items-center justify-center text-white text-xs font-bold px-1 shadow-md">
            {{ $itens->sum('quantity') }}
        </span>
        @endif
    </a>

    @yield('dashboard')
    
    @if(request()->routeIs('user.dashboard'))
        @include('user.dashboard-content')
        @include('produtos.index')
    @endif
</section>

<script>
    //menu hamburguer mobile
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

    // Busca automática de CEP via API (ViaCEP) user/profile --modal
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                // Feedback visual de carregamento
                document.body.style.cursor = 'wait';
                this.readOnly = true;
                const originalPlaceholder = this.placeholder;
                this.placeholder = 'Buscando...';

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            if(document.getElementById('rua')) document.getElementById('rua').value = data.logradouro;
                            if(document.getElementById('bairro')) document.getElementById('bairro').value = data.bairro;
                            if(document.getElementById('cidade')) document.getElementById('cidade').value = data.localidade;
                            if(document.getElementById('estado')) document.getElementById('estado').value = data.uf;
                            if(document.getElementById('numero')) document.getElementById('numero').focus();
                            
                            this.dataset.valid = 'true';
                            this.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                            this.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ icon: 'error', title: 'CEP não encontrado', text: 'Verifique o número digitado.', confirmButtonColor: '#4f46e5' });
                            } else {
                                alert('CEP não encontrado.');
                            }
                            this.dataset.valid = 'false';
                            this.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                            this.classList.remove('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');
                            
                            // Limpar campos se não encontrado
                            if(document.getElementById('rua')) document.getElementById('rua').value = '';
                            if(document.getElementById('bairro')) document.getElementById('bairro').value = '';
                            if(document.getElementById('cidade')) document.getElementById('cidade').value = '';
                            if(document.getElementById('estado')) document.getElementById('estado').value = '';
                        }
                    })
                    .catch(error => { console.error('Erro ao buscar CEP:', error); this.dataset.valid = 'false'; })
                    .finally(() => {
                        document.body.style.cursor = 'default';
                        this.readOnly = false;
                        this.placeholder = originalPlaceholder;
                    });
            }
        });
    }

    // Notification polling
    const notifInterval = setInterval(() => {
        fetch('{{ route("notifications.latest") }}')
            .then(r => r.json())
            .then(data => {
                const event = new CustomEvent('notifications-update', { detail: data });
                window.dispatchEvent(event);
            })
            .catch(() => {});
    }, 15000);

    // Auto-cleanup
    window.addEventListener('beforeunload', () => clearInterval(notifInterval));
});

// AJAX favorite toggle
document.addEventListener('submit', function(e) {
    const form = e.target.closest('.favorite-form');
    if (!form) return;

    e.preventDefault();

    const button = form.querySelector('button');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.favorited) {
            button.classList.remove('text-gray-400', 'hover:text-red-600');
            button.classList.add('text-red-600');
        } else {
            button.classList.remove('text-red-600');
            button.classList.add('text-gray-400', 'hover:text-red-600');
        }
    })
    .catch(() => {
        location.reload();
    });
});

function notificationBell() {
    return {
        open: false,
        count: 0,
        items: [],
        init() {
            this.fetchNotifications();
            window.addEventListener('notifications-update', (e) => {
                this.count = e.detail.count;
                this.items = e.detail.notifications || [];
            });
        },
        toggle() {
            this.open = !this.open;
            if (this.open) this.fetchNotifications();
        },
        fetchNotifications() {
            fetch('{{ route("notifications.latest") }}')
                .then(r => r.json())
                .then(data => {
                    this.count = data.count;
                    this.items = data.notifications || [];
                })
                .catch(() => {});
        },
        bgColor(color) {
            const colors = { green: '#dcfce7', blue: '#dbeafe', red: '#fee2e2', yellow: '#fef9c3', purple: '#f3e8ff' };
            return colors[color] || '#f3f4f6';
        },
        fgColor(color) {
            const colors = { green: '#16a34a', blue: '#2563eb', red: '#dc2626', yellow: '#ca8a04', purple: '#9333ea' };
            return colors[color] || '#6b7280';
        },
        timeAgo(date) {
            const now = new Date();
            const d = new Date(date);
            const diff = Math.floor((now - d) / 1000);
            if (diff < 60) return 'agora';
            if (diff < 3600) return Math.floor(diff / 60) + 'min';
            if (diff < 86400) return Math.floor(diff / 3600) + 'h';
            return d.toLocaleDateString('pt-BR');
        }
    };
}
</script>
@endsection
