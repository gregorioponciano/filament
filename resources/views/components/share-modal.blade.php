@props(['productName' => 'produto'])

<div
    id="shareModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-md transition-all duration-300"
    onclick="if(event.target === this) fecharShareModal()"
>
    <div class="w-full max-w-sm rounded-3xl bg-white shadow-2xl mx-4 transform transition-all duration-300 scale-95 animate-modalIn">
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-500 rounded-t-3xl p-6 text-white">
            <button onclick="fecharShareModal()"
                    class="absolute right-4 top-4 rounded-full bg-white/20 p-2 text-white hover:bg-white/30 transition backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="flex items-center gap-4">
                <div class="rounded-full bg-white/30 p-3 backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold">Compartilhar</h3>
                    <p class="text-sm text-blue-100">{{ $productName }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @php
                $encodedUrl = 'ENCODE_URL_PLACEHOLDER';
                $encodedTitle = urlencode('Olha isso que encontrei 😍');
            @endphp
            <div class="grid grid-cols-3 gap-4 mb-6" id="shareButtonsContainer">
                <a id="shareWhatsapp" href="#"
                   target="_blank"
                   class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-green-50 hover:bg-green-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png"
                             class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110"
                             alt="WhatsApp">
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">WhatsApp</span>
                    <span class="text-[10px] text-gray-500">Conversar</span>
                </a>

                <a id="shareFacebook" href="#"
                   target="_blank"
                   class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-blue-50 hover:bg-blue-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                             class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110"
                             alt="Facebook">
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white"></span>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Facebook</span>
                    <span class="text-[10px] text-gray-500">Compartilhar</span>
                </a>

                <button id="shareInstagram" type="button"
                        class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 hover:from-purple-100 hover:via-pink-100 hover:to-orange-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png"
                             class="w-12 h-12 sm:w-14 sm:h-14 transition-all duration-300 group-hover:scale-110"
                             alt="Instagram">
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full border-2 border-white"></span>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Instagram</span>
                    <span class="text-[10px] text-gray-500">Copiar link</span>
                </button>
            </div>

            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <span class="text-xs font-medium text-gray-400">OU</span>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>
                <div class="relative">
                    <input type="text"
                           id="shareLinkInput"
                           readonly
                           class="w-full px-4 py-3 pr-20 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button onclick="copiarLinkDireto()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1 copy-direct-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                        Copiar
                    </button>
                </div>
            </div>

            <div id="shareFeedback" class="hidden">
                <div class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none">
                    <div id="shareSuccessToast"
                         class="bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transform transition-all duration-500 translate-y-0 opacity-100">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center animate-bounce">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold" id="shareFeedbackMsg">Link copiado com sucesso!</p>
                            <p class="text-xs text-gray-400" id="shareFeedbackSub"></p>
                        </div>
                    </div>
                </div>
                <canvas id="shareConfettiCanvas" class="fixed inset-0 pointer-events-none z-40"></canvas>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 rounded-b-3xl border-t border-gray-100">
            <p class="text-xs text-center text-gray-500">
                🔗 Link compartilhável •
                <span class="font-medium text-gray-700" id="shareLinkPreview"></span>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
let shareConfettiInterval;

function abrirShareModal(url, nome) {
    const modal = document.getElementById('shareModal');
    if (!modal) return;

    const encodedUrl = encodeURIComponent(url);
    const encodedTitle = encodeURIComponent('Olha isso que encontrei 😍');

    document.getElementById('shareLinkInput').value = url;
    document.getElementById('shareLinkPreview').textContent = url.length > 30 ? url.substring(0, 30) + '...' : url;
    document.getElementById('shareWhatsapp').href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
    document.getElementById('shareFacebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;

    modal.classList.remove('hidden');
    setTimeout(() => { modal.classList.add('flex'); }, 10);
}

function fecharShareModal() {
    const modal = document.getElementById('shareModal');
    if (!modal) return;
    const content = modal.querySelector('.transform');
    if (content) {
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (content) { content.classList.remove('scale-95', 'opacity-0'); }
        }, 300);
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

document.addEventListener('click', function(e) {
    const btn = e.target.closest('[data-share-url]');
    if (btn) {
        const url = btn.dataset.shareUrl;
        const nome = btn.dataset.shareName || 'produto';
        abrirShareModal(url, nome);
    }
});

document.getElementById('shareInstagram')?.addEventListener('click', function() {
    const url = document.getElementById('shareLinkInput').value;
    if (!url) return;
    navigator.clipboard.writeText(url).then(() => {
        fecharShareModal();
        mostrarShareFeedback('Instagram', url);
    });
});

function copiarLinkDireto() {
    const input = document.getElementById('shareLinkInput');
    if (!input) return;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = document.querySelector('.copy-direct-btn');
        if (btn) {
            const orig = btn.innerHTML;
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copiado!';
            btn.classList.add('bg-green-600');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('bg-green-600'); }, 2000);
        }
        mostrarShareFeedbackSimples('Link copiado!');
    });
}

function mostrarShareFeedback(rede, link) {
    const el = document.getElementById('shareFeedback');
    if (!el) return;
    document.getElementById('shareFeedbackMsg').textContent = `Link copiado para ${rede}!`;
    document.getElementById('shareFeedbackSub').textContent = 'Agora é só colar e compartilhar 📱';
    el.classList.remove('hidden');
    iniciarShareConfetti();
    setTimeout(() => {
        const toast = document.getElementById('shareSuccessToast');
        if (toast) { toast.classList.add('translate-y-full', 'opacity-0'); }
        setTimeout(() => {
            el.classList.add('hidden');
            if (toast) { toast.classList.remove('translate-y-full', 'opacity-0'); }
            pararShareConfetti();
        }, 500);
    }, 3000);
}

function mostrarShareFeedbackSimples(msg) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-2 animate-slideUp';
    toast.innerHTML = `<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm font-medium">${msg}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.classList.add('animate-slideDown'); setTimeout(() => toast.remove(), 300); }, 2000);
}

function iniciarShareConfetti() {
    const canvas = document.getElementById('shareConfettiCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let w, h, particles = [];
    function resize() { w = window.innerWidth; h = window.innerHeight; canvas.width = w; canvas.height = h; }
    resize();
    for (let i = 0; i < 50; i++) particles.push({ x: Math.random() * w, y: Math.random() * h - h, size: Math.random() * 5 + 2, speedY: Math.random() * 3 + 2, speedX: Math.random() * 2 - 1, color: `hsl(${Math.random() * 360}, 70%, 60%)` });
    function animate() {
        ctx.clearRect(0, 0, w, h);
        particles.forEach((p, i) => { p.y += p.speedY; p.x += p.speedX; ctx.fillStyle = p.color; ctx.fillRect(p.x, p.y, p.size, p.size); if (p.y > h) particles.splice(i, 1); });
        if (particles.length < 30) for (let i = 0; i < 5; i++) particles.push({ x: Math.random() * w, y: -10, size: Math.random() * 5 + 2, speedY: Math.random() * 3 + 2, speedX: Math.random() * 2 - 1, color: `hsl(${Math.random() * 360}, 70%, 60%)` });
        shareConfettiInterval = requestAnimationFrame(animate);
    }
    animate();
    window.addEventListener('resize', resize);
}
function pararShareConfetti() {
    if (shareConfettiInterval) { cancelAnimationFrame(shareConfettiInterval); shareConfettiInterval = null; const c = document.getElementById('shareConfettiCanvas'); if (c) c.getContext('2d').clearRect(0, 0, c.width, c.height); }
}
</script>
<style>
    #shareModal .animate-modalIn { animation: shareModalIn 0.3s ease-out forwards; }
    @keyframes shareModalIn { from { opacity: 0; transform: scale(0.95) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    #shareSuccessToast { transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
    #shareSuccessToast.translate-y-full { transform: translateY(100%); opacity: 0; }
    .copy-direct-btn { transition: all 0.2s ease; }
    .copy-direct-btn.bg-green-600 { background-color: #059669; }
</style>
@endpush
