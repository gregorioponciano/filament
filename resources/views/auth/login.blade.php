@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-primary rounded-2xl shadow-lg p-8">
        
        <div class="border-b rounded-2xl mb-4">
            <h3 class="text-2xl text-center text-gray-800">Login</h3>
        </div>

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
        
        
        {{-- FORMULARIO --}}
        <form action="{{ route('store.login') }}" method="POST" class="space-y-4">
            @csrf
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="seu@email.com" class="peer invalid:border-pink-500 invalid:text-pink-600 focus:border-sky-500 focus:outline focus:outline-sky-500 focus:invalid:border-pink-500 focus:invalid:outline-pink-500 disabled:border-gray-200 disabled:bg-gray-50 disabled:text-gray-500 disabled:shadow-none dark:disabled:border-gray-700 dark:disabled:bg-gray-800/20  mt-1 w-full rounded-lg border border-gray-300 px-4 py-2  ">
           <p class="invisible peer-invalid:visible ...">Por favor, insira um email válido.</p>
            </label> </div>
            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" placeholder="••••••••" class="invalid:border-pink-500 invalid:text-pink-600 focus:border-sky-500 focus:outline focus:outline-sky-500 focus:invalid:border-pink-500 focus:invalid:outline-pink-500 disabled:border-gray-200 disabled:bg-gray-50 disabled:text-gray-500 disabled:shadow-none dark:disabled:border-gray-700 dark:disabled:bg-gray-800/20  mt-1 w-full rounded-lg border border-gray-300 px-4 py-2  ">
            </div>
            {{-- Botão --}}
            <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2 font-semibold text-white hover:bg-hover transition">Entrar</button>
        </form>
        {{-- Link register --}}
        <div class="text-center py-4">
            <a href="#">Esqueceu a senha?</a>
                   <a href="{{ route('show.register') }}" class="font-semibold text-indigo-600 hover:underline">Criar conta</a>
        </div>
 
    </div>
</section>
@endsection
