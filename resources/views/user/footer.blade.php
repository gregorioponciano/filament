<footer class="bg-gray-900 text-gray-300 mt-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div>
                <h4 class="text-white font-semibold mb-3">A Loja</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('user.dashboard') }}" class="hover:text-white transition">Início</a></li>
                    <li><a href="{{ route('favorites.index') }}" class="hover:text-white transition">Favoritos</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">Meus Pedidos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Ajuda</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('show.suporte') }}" class="hover:text-white transition">Suporte</a></li>
                    <li><a href="{{ route('show.suporte') }}" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('show.profile') }}" class="hover:text-white transition">Configurações</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Contato</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">mail</span>
                        suporte@loja.com
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">call</span>
                        (11) 99999-8888
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm">
            <p>&copy; {{ date('Y') }} Todos os direitos reservados.</p>
            <p class="text-gray-500">Feito com dedicação</p>
        </div>
    </div>
</footer>