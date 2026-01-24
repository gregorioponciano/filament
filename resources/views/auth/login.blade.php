@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section style="background-image: url('{{ asset('storage/images/fundo.jpg') }}');" class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat">
    <div class="w-full max-w-md bg-secondary rounded-2xl shadow-lg p-8">
        
        <div class="border-b rounded-2xl mb-4">
            <h3 class="text-2xl text-center text-h3">Login</h3>
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
                <label for="email" class="block text-sm font-medium ">Email
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="seu@email.com" class="peer invalid:border-pink-500 invalid:text-pink-600 focus:border-yellow-500 focus:outline focus:outline-yellow-500 focus:invalid:border-pink-500 focus:invalid:outline-pink-500 disabled:border-gray-200 disabled:bg-gray-50 disabled:text-gray-500 disabled:shadow-none dark:disabled:border-gray-700 dark:disabled:bg-gray-800/20  mt-1 w-full rounded-lg border border-gray-300 px-4 py-2  ">
           <p class="invisible peer-invalid:visible ...">Por favor, insira um email válido.</p>
            </label> </div>
            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium ">Senha</label>
                <input type="password" name="password" placeholder="••••••••" class="focus:border-yellow-500 focus:outline focus:outline-yellow-500    mt-1 w-full rounded-lg border border-gray-300 px-4 py-2">
            </div>
            {{-- Botão --}}
            <button  type="submit" class="w-full rounded-lg py-2 font-semibold bg-button-primary hover:bg-hover-primary text-text-primary cursor-pointer">Entrar</button>
        </form>
        {{-- Link register --}}
        <div class="text-center py-4">
            <a href="#">Esqueceu a senha?</a>
                   <a href="{{ route('show.register') }}" class="font-semibold text-link-primary hover:underline">Criar conta</a>
        </div>
        
 
    </div>
</section>
@endsection
