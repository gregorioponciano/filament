<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
  <div class="relative overflow-hidden rounded-2xl group shadow-lg">
    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">

      <div class="min-w-full px-1 sm:px-2">
        <a href="{{ route('user.dashboard') }}" class="block">
          <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-yellow-500 via-black to-blue-500 p-1 shadow-inner h-full">
            <div class="rounded-2xl bg-white px-6 py-10 sm:px-10 sm:py-14 text-center">
              <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                <span class="material-symbols-outlined text-3xl">store</span>
              </span>
              <blockquote class="text-xl sm:text-2xl md:text-3xl font-bold italic text-black">
                Seja Bem-Vindo à
                <span class="relative inline-block mt-1">
                  <span class="absolute -inset-1 -skew-y-3 bg-yellow-400"></span>
                  <span class="relative text-black">{{ $customizations->nome ?? 'Loja' }}</span>
                </span>
              </blockquote>
              <p class="mt-3 text-sm sm:text-base text-gray-500">Confira nossos produtos e ofertas especiais</p>
            </div>
          </div>
        </a>
      </div>

      <div class="min-w-full px-1 sm:px-2">
        <a href="{{ route('user.dashboard') }}" class="block">
          <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 via-black to-yellow-500 p-1 shadow-inner h-full">
            <div class="rounded-2xl bg-white px-6 py-10 sm:px-10 sm:py-14 text-center">
              <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 mb-4">
                <span class="material-symbols-outlined text-3xl">local_offer</span>
              </span>
              <blockquote class="text-xl sm:text-2xl md:text-3xl font-bold italic text-black">
                Promoções
                <span class="relative inline-block mt-1">
                  <span class="absolute -inset-1 -skew-y-3 bg-yellow-400"></span>
                  <span class="relative text-black">Exclusivas</span>
                </span>
              </blockquote>
              <p class="mt-3 text-sm sm:text-base text-gray-500">Aproveite ofertas imperdíveis!</p>
            </div>
          </div>
        </a>
      </div>

      <div class="min-w-full px-1 sm:px-2">
        <a href="{{ route('orders.index') }}" class="block">
          <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-500 via-black to-yellow-500 p-1 shadow-inner h-full">
            <div class="rounded-2xl bg-white px-6 py-10 sm:px-10 sm:py-14 text-center">
              <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-100 text-green-600 mb-4">
                <span class="material-symbols-outlined text-3xl">pix</span>
              </span>
              <blockquote class="text-xl sm:text-2xl md:text-3xl font-bold italic text-black">
                Pagamento
                <span class="relative inline-block mt-1">
                  <span class="absolute -inset-1 -skew-y-3 bg-green-400"></span>
                  <span class="relative text-black">PIX</span>
                </span>
              </blockquote>
              <p class="mt-3 text-sm sm:text-base text-gray-500">Receba em até 10 segundos!</p>
            </div>
          </div>
        </a>
      </div>

    </div>

    <button id="prev"
      class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 sm:px-3 py-2 text-white hover:bg-black/80 transition-all opacity-0 group-hover:opacity-100 backdrop-blur-sm">
      ‹
    </button>

    <button id="next"
      class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 sm:px-3 py-2 text-white hover:bg-black/80 transition-all opacity-0 group-hover:opacity-100 backdrop-blur-sm">
      ›
    </button>

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
      <span class="carousel-dot h-2 w-2 rounded-full bg-white/90 shadow-lg ring-1 ring-white/50"></span>
      <span class="carousel-dot h-2 w-2 rounded-full bg-white/40 shadow"></span>
      <span class="carousel-dot h-2 w-2 rounded-full bg-white/40 shadow"></span>
    </div>
  </div>
</div>

<script>
  const carousel = document.getElementById('carousel');
  const slides = carousel.children.length;
  let index = 0;
  let interval;

  function showSlide(i) {
    index = i;
    carousel.style.transform = `translateX(-${i * 100}%)`;
    document.querySelectorAll('.carousel-dot').forEach((dot, idx) => {
      dot.classList.toggle('bg-white/80', idx === index);
      dot.classList.toggle('bg-white/40', idx !== index);
    });
  }

  function nextSlide() { showSlide((index + 1) % slides); }
  function prevSlide() { showSlide((index - 1 + slides) % slides); }

  document.getElementById('next').addEventListener('click', () => { clearInterval(interval); nextSlide(); interval = setInterval(nextSlide, 5000); });
  document.getElementById('prev').addEventListener('click', () => { clearInterval(interval); prevSlide(); interval = setInterval(nextSlide, 5000); });

  interval = setInterval(nextSlide, 5000);
</script>