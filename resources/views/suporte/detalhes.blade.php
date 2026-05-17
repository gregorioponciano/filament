@extends('user.dashboard')
@section('title', 'Detalhes do Chamado')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-4xl px-4 py-8">
    <div class="animate-fade-in-up flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 mb-6 shadow-sm">
        <a href="{{ route('suporte.chamados') }}"
            class="group flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition group-hover:-translate-x-0.5">arrow_circle_left</span>
            Voltar
        </a>
        <button data-modal="ticket"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
            <span class="material-symbols-outlined text-base">add</span>
            Novo Chamado
        </button>
    </div>

    <div class="animate-fade-in-up stagger-1 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 bg-gray-50 p-6">
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-gray-400">confirmation_number</span>
                        <span class="text-sm text-gray-500">#{{ $suporte->id }}</span>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $suporte->assunto }}</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Aberto em {{ $suporte->created_at->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}
                    </p>
                </div>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold
                    @if($suporte->status == 'aberto') bg-green-100 text-green-800
                    @elseif($suporte->status == 'fechado') bg-gray-100 text-gray-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($suporte->status) }}
                </span>
            </div>
        </div>

        <div class="space-y-6 p-6 sm:p-8">
            <div class="flex items-start gap-4 animate-fade-in-up">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-600">
                    <span class="material-symbols-outlined">person</span>
                </span>
                <div class="flex-1 rounded-xl rounded-tl-none border border-gray-200 bg-gray-50 p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">{{ $suporte->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $suporte->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $suporte->mensagem }}</p>
                </div>
            </div>

            @if($suporte->resposta)
                <div class="flex items-start gap-4 animate-fade-in-up stagger-1">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <span class="material-symbols-outlined">support_agent</span>
                    </span>
                    <div class="flex-1 rounded-xl rounded-tr-none border border-blue-200 bg-blue-50 p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <p class="text-sm font-semibold text-blue-900">Equipe de Suporte</p>
                        </div>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $suporte->resposta }}</p>
                    </div>
                </div>
            @else
                <div class="animate-fade-in-up stagger-2 border-t border-gray-100 pt-8 text-center">
                    <span class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                        <span class="material-symbols-outlined text-yellow-600">hourglass_empty</span>
                    </span>
                    <p class="text-sm text-gray-500">Aguardando resposta da equipe de suporte.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<x-ticket-modal />
@endsection
