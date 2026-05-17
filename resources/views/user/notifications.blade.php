@extends('user.dashboard')
@section('title', 'Notificações')

@section('dashboard')
@include('user.dashboard-content')

<x-flash-messages />

<div class="mx-auto max-w-4xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <a href="{{ url('/user') }}"
           class="group inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
            <span class="material-symbols-outlined text-2xl transition-transform group-hover:-translate-x-1">
                arrow_circle_left
            </span>
            Voltar
        </a>
        <span class="text-sm font-medium text-gray-400">Notificações</span>
    </div>

    <div class="animate-fade-in-up mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notificações</h1>
            <p class="text-sm text-gray-500">Suas notificações e alertas</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex rounded-lg border border-gray-200 overflow-hidden" x-data="{ filter: 'all' }">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                        class="px-4 py-2 text-sm font-medium transition">Todas</button>
                <button @click="filter = 'unread'" :class="filter === 'unread' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                        class="px-4 py-2 text-sm font-medium transition border-x border-gray-200">Não lidas</button>
            </div>
            @if($notifications->where('read', false)->count() > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                        <span class="material-symbols-outlined text-base">done_all</span>
                        <span class="hidden sm:inline">Marcar todas como lidas</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if($notifications->count() === 0)
        <div class="animate-fade-in-scale flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-white py-16 px-4 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">notifications_off</span>
            <h3 class="text-xl font-semibold text-gray-900 mb-1">Nenhuma notificação</h3>
            <p class="text-sm text-gray-500">Você não possui notificações no momento.</p>
        </div>
    @else
        <div class="space-y-3" x-data="{ filter: 'all' }">
            @foreach($notifications as $notification)
                <div class="animate-fade-in-up rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md hover:border-gray-200"
                     x-show="filter === 'all' || filter === 'unread' && {{ $notification->read ? 'false' : 'true' }}"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     style="animation-delay: {{ $loop->index * 0.05 }}s">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl"
                             style="background-color: {{ match($notification->color) { 'green' => '#dcfce7', 'blue' => '#dbeafe', 'red' => '#fee2e2', 'yellow' => '#fef9c3', 'purple' => '#f3e8ff', default => '#f3f4f6' } }};">
                            <span class="material-symbols-outlined"
                                  style="color: {{ match($notification->color) { 'green' => '#16a34a', 'blue' => '#2563eb', 'red' => '#dc2626', 'yellow' => '#ca8a04', 'purple' => '#9333ea', default => '#6b7280' } }};">
                                {{ $notification->icon }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900 {{ !$notification->read ? '' : 'text-sm' }}">
                                        {{ $notification->title }}
                                        @if(!$notification->read)
                                            <span class="ml-2 inline-block h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                        @endif
                                    </h4>
                                    @if($notification->message)
                                        <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                    @endif
                                </div>
                                <span class="shrink-0 text-xs text-gray-400 whitespace-nowrap">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="mt-3 flex items-center gap-3">
                                @if($notification->action_url)
                                    <a href="{{ $notification->action_url }}"
                                       class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline transition">
                                        Ver detalhes
                                    </a>
                                @endif
                                @if(!$notification->read)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                                            Marcar como lida
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($notifications->hasPages())
            <div class="mt-8">{{ $notifications->links() }}</div>
        @endif
    @endif
</div>
@endsection
