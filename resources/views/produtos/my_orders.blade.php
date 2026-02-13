@extends('user.dashboard')
@section('title', 'Meus Pedidos')

@section('dashboard')
@include('user.dashboard-content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Meus Pedidos</h2>

    @if(isset($orders) && $orders->count() > 0)
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status == 'concluido' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }} {{-- ucfirst deixa a primeira letra maiuscula --}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('produtos.orders', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalhes</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">shopping_bag</span>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Você ainda não fez pedidos</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">Explore nossos produtos e faça sua primeira compra.</p>
            <a href="{{ route('user.dashboard') }}" class="rounded-lg bg-button-primary px-6 py-2.5 font-medium hover:bg-hover-primary transition">Ir às compras</a>
        </div>
    @endif
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    @php
        $favoritos = Auth::check() ? Auth::user()->favorites()->whereHas('categoria', function ($query) {
            $query->where('ativo', true);
        })->get() : collect([]);
    @endphp
 <h2 class="text-2xl font-bold text-gray-800 mb-6">Meus Favoritos </h2>
    @if($favoritos->count() > 0)
        @include('produtos.index', ['produtos' => $favoritos])
    @else
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">favorite_border</span>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Você ainda não tem favoritos</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">Salve os produtos que você mais gosta aqui para encontrá-los facilmente depois.</p>
            <a href="{{ route('user.dashboard') }}" class="rounded-lg bg-button-primary px-6 py-2.5 font-medium hover:bg-hover-primary transition">Explorar produtos</a>
        </div>
    @endif
</div>
@endsection
