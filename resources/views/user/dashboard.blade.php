@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<section class=" box-border z-0">
    <header class=" bg-primary shadow-sm sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                {{-- Logo --}}
                <div id="mobileMenuBtn" class="flex items-center gap-3 shrink-0 cursor-pointer md:cursor-default">
                    <img 
                        src="{{ asset('storage/' . $customizations->imagem) }}" 
                        alt="{{ $customizations->nome }}"
                        class="w-30 h-auto hover:scale-125 object-cover transition group-hover:scale-110"
                    />
                </div>

<a href="{{ route('show.carrinho') }}"class="bg-primary rounded-full h-12 w-12 flex align-center items-center justify-center text-white fixed bottom-10 right-5 cursor-pointer ">
    <span class="material-symbols-outlined">
    shopping_cart
    <p class="fixed bottom-18 right-3 bg-primary rounded-full h-8 w-8 flex align-center justify-center text-white">{{ $itens->count() }}</p>
    </span>
</a>



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
                        <div id="categoryDropdown" class="hidden fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-primary shadow-2xl z-50 overflow-y-auto md:absolute md:h-auto md:top-full md:mt-2 md:w-56 md:rounded-xl md:shadow-lg md:ring-1 md:ring-black/5 transition-all duration-300 ease-out origin-top-left -translate-x-full opacity-0 md:translate-x-0 md:opacity-0 md:scale-95 md:-translate-y-2">
                            <div class="max-h-80 overflow-y-auto py-2">

                                <a href="{{ Route('user.dashboard') }}" class="flex align-items-center px-4  text-xl text-gray-700 hover:bg-hover-primary hover:scale-75 transition">
                                    <span class="material-symbols-outlined">
                                    home
                                    </span>
                                    Inicio</a>
                                    <hr>
                                    <a href="{{ Route('favorites.index') }}" class="flex align-items-center px-4 mt-2   text-gray-700 hover:bg-hover-primary hover:scale-75 transition">
                                        <span class="material-symbols-outlined">
                                            favorite
                                    </span>
                                    Favoritos</a>
                             
                                @php
                                    // Mapa de ícones: 'slug-da-categoria' => 'nome-do-icone-material'
                                    $icones = [
                                        'camisetas' => 'apparel',
                                        'blusas' => 'face_5',
                                        'bone' => 'face_5',
                                        'casacos' => 'face_5',
                                        'shorts' => 'face_5',
                                    ];
                                @endphp
                                @foreach ($categorias as $categoria)
                                    <a href="{{ route('show.categorias', $categoria->slug) }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-hover hover:bg-hover-primary hover:scale-75 transition">
                                        <span class="material-symbols-outlined">{{ $icones[$categoria->slug] ?? $categoria->icone ?? 'category' }}</span>
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

                        <div class="py-2">
                            <a href="{{ route('show.profile') }}" class="flex items-center px-4 mt-2 text-sm hover:bg-hover-primary hover:scale-75 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <p>Configurações</p></a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-hover-primary hover:scale-75 transition">
                                <span class="material-symbols-outlined">
                                notifications
                                </span>
                                Suporte</a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-hover-primary hover:scale-75 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                Suporte</a>
                        </div>

                        <div class="border-t px-0 py-1">
                            <form action="{{ route('store.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left  py-2
                                flex items-center px-4 cursor-pointer text-sm font-semibold text-red-600 hover:bg-hover-primary hover:scale-75 transition">
                                    <p>Sair</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    </button>
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
