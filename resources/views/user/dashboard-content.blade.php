<div class="mx-auto max-w-6xl px-4 py-10">
  <div class="relative overflow-hidden rounded-2xl">

    <!-- Slides -->
    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">

      <!-- Slide 1 -->
      <div class="min-w-full px-2">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-500 via-black to-blue-500 p-1 shadow-xl">
          <div class="rounded-2xl bg-white p-8 text-center">
            <blockquote class="text-2xl font-semibold italic text-black md:text-3xl">
              Seja Bem Vindo a
              <span class="relative inline-block">
                <span class="absolute -inset-1 -skew-y-3 bg-orange-500"></span>
                <span class="relative text-black">Loja</span>
              </span>
            </blockquote>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="min-w-full px-2">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 via-black to-orange-500 p-1 shadow-xl">
          <div class="rounded-2xl bg-white p-8 text-center">
            <blockquote class="text-2xl font-semibold italic text-black md:text-3xl">
              Promoções
              <span class="relative inline-block">
                <span class="absolute -inset-1 -skew-y-3 bg-orange-500"></span>
                <span class="relative text-black">Exclusivas</span>
              </span>
            </blockquote>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="min-w-full px-2">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-500 via-black to-orange-500 p-1 shadow-xl">
          <div class="rounded-2xl bg-white p-8 text-center">
            <blockquote class="text-2xl font-semibold italic text-black md:text-3xl">
              Entrega
              <span class="relative inline-block">
                <span class="absolute -inset-1 -skew-y-3 bg-orange-500"></span>
                <span class="relative text-black">Rápida</span>
              </span>
            </blockquote>
          </div>
        </div>
      </div>

    </div>

    <!-- Botões -->
    <button id="prev"
      class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/60 px-3 py-2 text-white hover:bg-black">
      ‹
    </button>

    <button id="next"
      class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/60 px-3 py-2 text-white hover:bg-black">
      ›
    </button>
  </div>
</div>






<script>
  const carousel = document.getElementById('carousel');
  const slides = carousel.children.length;
  let index = 0;

  function showSlide(i) {
    carousel.style.transform = `translateX(-${i * 100}%)`;
  }

  function nextSlide() {
    index = (index + 1) % slides;
    showSlide(index);
  }

  function prevSlide() {
    index = (index - 1 + slides) % slides;
    showSlide(index);
  }

  document.getElementById('next').addEventListener('click', nextSlide);
  document.getElementById('prev').addEventListener('click', prevSlide);

  // Auto play
  setInterval(nextSlide, 5000); // 5 segundos
</script>

