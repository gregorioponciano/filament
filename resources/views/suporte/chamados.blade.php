@extends('user.dashboard')
@section('title', 'Meus Chamados')

@section('dashboard')
@include('user.dashboard-content')

<x-flash-messages />

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="animate-fade-in-up flex flex-row items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 mb-6 shadow-sm">
        <a href="{{ route('show.suporte') }}"
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

    <div class="text-center mb-8 animate-fade-in-up stagger-1">
        <h1 class="text-2xl font-bold text-gray-900">Meus Chamados</h1>
        <p class="text-sm text-gray-500">Acompanhe seus pedidos de ajuda.</p>
    </div>

    <div class="animate-fade-in-up stagger-2 rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @if($chamados->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <span class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                    <span class="material-symbols-outlined text-3xl text-blue-600">inbox</span>
                </span>
                <h3 class="text-lg font-semibold text-gray-800">Nenhum chamado</h3>
                <p class="mt-1 text-sm text-gray-500">Você ainda não abriu nenhum chamado.</p>
                <button data-modal="ticket"
                        class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Abrir chamado
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Assunto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($chamados as $chamado)
                            <tr onclick="window.location='{{ route('suporte.detalhes', $chamado) }}'"
                                class="hover:bg-gray-50 cursor-pointer transition">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $chamado->assunto }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($chamado->mensagem, 80) }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold
                                        @if($chamado->status == 'aberto') bg-green-100 text-green-800
                                        @elseif($chamado->status == 'fechado') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($chamado->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $chamado->created_at->isoFormat('D [de] MMM [de] YYYY, HH:mm') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($chamados->hasPages())
                <div class="border-t px-4 py-3">{{ $chamados->links() }}</div>
            @endif
        @endif
    </div>
</div>

<x-ticket-modal />
@endsection
