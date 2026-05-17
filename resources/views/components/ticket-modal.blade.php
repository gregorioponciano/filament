<div id="ticket-modal" class="fixed inset-0 z-100 hidden overflow-y-auto">
    <div id="ticket-modal-backdrop" class="fixed inset-0 bg-black/70"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div id="ticket-modal-panel"
             class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 shadow-xl transition-all opacity-0 scale-95">
            <form id="ticket-form" action="{{ route('store.suporte') }}" method="POST" class="space-y-5">
                @csrf
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Abrir Chamado</h3>
                    <button type="button" id="close-ticket-modal-btn" class="text-gray-400 hover:text-gray-600 transition">&times;</button>
                </div>
                <div>
                    <label for="assunto" class="mb-1 block text-sm font-semibold text-gray-700">Assunto</label>
                    <input id="assunto" type="text" required name="assunto" maxlength="255"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('assunto')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="mensagem" class="mb-1 block text-sm font-semibold text-gray-700">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" required rows="4"
                              class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" class="close-modal-btn rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button type="submit" id="ticket-submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition disabled:opacity-50">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('ticket-modal');
    const panel = document.getElementById('ticket-modal-panel');
    const openBtns = document.querySelectorAll('[data-modal="ticket"]');
    const closeBtns = document.querySelectorAll('#close-ticket-modal-btn, .close-modal-btn, #ticket-modal-backdrop');

    const openModal = () => {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => panel.classList.remove('opacity-0', 'scale-95'));
    };

    const closeModal = () => {
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    };

    openBtns.forEach(btn => btn.addEventListener('click', openModal));
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    document.getElementById('ticket-form')?.addEventListener('submit', () => {
        const btn = document.getElementById('ticket-submit');
        btn.disabled = true;
        btn.innerHTML = 'Enviando...';
    });
});
</script>
