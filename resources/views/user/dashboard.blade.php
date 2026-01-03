@extends('layouts.app')
@section('title', 'Dashboard')

<section class="min-h-screen bg-gray-50">
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <span class="text-lg font-bold text-gray-800">
                        MinhaAplicação
                    </span>
                </div>

                {{-- Dropdown --}}
                <div class="relative">

                    <button
                        onclick="toggleDropDown()"
                        class="flex items-center gap-2 rounded-full bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                    >
                        {{ auth()->user()->name ?? 'admin' }}

                        <svg class="size-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>

                    {{-- Menu --}}
                    <div
                        id="userDropdown"
                        class="hidden absolute right-0 mt-3 w-64 rounded-xl bg-white shadow-lg ring-1 ring-black/5"
                    >
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-gray-700">
                                {{ auth()->user()->name ?? 'admin' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ auth()->user()->email ?? 'admin@demo.com' }}
                            </p>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('show.profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Perfil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Suporte
                            </a>
                        </div>

                        <div class="border-t px-4 py-2">
                            <form action="{{ route('store.logout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-2 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-md"
                                >
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </header>

    {{-- Conteúdo --}}
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Bem-vindo 👋
        </h1>
        <p class="mt-2 text-gray-600">
            Aqui está seu painel inicial.
        </p>
    </main>

</section>

<script>
function toggleDropDown() {
    const dropdown = document.getElementById('userDropdown')
    dropdown.classList.toggle('hidden')
}

// Fecha ao clicar fora
document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('userDropdown')
    const button = event.target.closest('button')

    if (!event.target.closest('#userDropdown') && !button) {
        dropdown.classList.add('hidden')
    }
})
</script>

