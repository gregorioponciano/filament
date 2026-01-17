@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<section class=" bg-bg box-border">
    <header class="bg-primary shadow-sm sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                {{-- Logo --}}
                <div id="mobileMenuBtn" class="flex items-center gap-3 shrink-0 cursor-pointer md:cursor-default">
                    @if($customizations && $customizations->image)
                        <!-- DEBUG URL: {{ asset('storage/' . $customizations->image) }} -->
                        <img 
                            src="{{ asset('storage/' . $customizations->image) }}" 
                            alt="{{ $customizations->nome }}"
                            class="w-30 hover:scale-125 transition object-cover rounded"
                        />
                    @endif
                </div>

                {{-- Search & Categories --}}
                <div class="flex flex-1 items-center gap-2 w-full md:max-w-2xl">
                    {{-- Category Dropdown --}}
                    <div class="relative">
                       <button
                        id="categoryBtn"
                        class="hidden md:flex  items-center gap-2 rounded-xl
                        bg-white border border-gray-200 shadow-sm px-4 py-2.5
                        text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all whitespace-nowrap"
                        >
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
                                    <a href="{{ route('show.categorias', $categoria->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-hover hover:text-text hover:scale-75 transition"> {{ $categoria->nome }}</a>
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
                    
                    {{-- User Dropdown --}}
                    <div class="relative shrink-0">
                    <button id="userBtn" class="flex items-center gap-2 rounded-full bg-white border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all">
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
    </div>
    </header>
    @yield('dashboard')
    
    @if(request()->routeIs('user.dashboard'))
        @include('user.dashboard-content')
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

    // Busca automática de CEP via API (ViaCEP)
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
});
</script>
@endsection
