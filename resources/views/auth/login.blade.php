@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-bg">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

            @if ($mensagem = Session::get('sucesso'))
            <p>{{$mensagem}}</p>
            @endif

        {{-- Erros --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('store.login') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="seu@email.com"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2
                           focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                >
            </div>

            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Senha
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2
                           focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                >
            </div>

            {{-- Botão --}}
            <button
                type="submit"
                class="w-full rounded-lg bg-indigo-600 py-2 font-semibold text-white
                       hover:bg-indigo-700 transition"
            >
                Entrar
            </button>
        </form>

        {{-- Link register --}}
        <p class="mt-6 text-center text-sm text-gray-600">
            Ainda não tem conta?
            <a href="{{ route('show.register') }}"
               class="font-semibold text-indigo-600 hover:underline">
                Criar conta
            </a>
        </p>

    </div>
</section>
@endsection
