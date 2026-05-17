@if(isset($produtos) && $produtos->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach ($produtos as $index => $produto)
      <div class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 card-enter stagger-{{ min($index % 6 + 1, 6) }}">

        <div class="relative w-full overflow-hidden bg-gray-100 aspect-square">
          <img 
            src="{{ asset('storage/' . $produto->imagem) }}" 
            alt="{{ $produto->nome }}"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
        </div>

        <div class="flex flex-1 flex-col p-5">

            <div class="mb-3 flex items-center justify-between">
                <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                  {{ $produto->categoria->nome ?? 'Geral' }}
                </span>

                <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-form inline-flex">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <button type="submit" 
                      class="transition-all duration-200 hover:scale-110 {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                        <span class="material-symbols-outlined text-xl">favorite</span>
                    </button>
                </form>
            </div>

            <h3 class="mb-1 line-clamp-1 text-base sm:text-lg font-bold text-gray-900" title="{{ $produto->nome }}">
              {{ \Illuminate\Support\Str::limit($produto->nome, 40) }}
            </h3>

            <p class="mb-4 line-clamp-2 text-sm text-gray-500 flex-1" title="{{ $produto->descricao }}">
              {{ \Illuminate\Support\Str::limit($produto->descricao, 60) }}
            </p>

            <div class="mb-4 flex items-center justify-between gap-4">
              <p class="text-lg sm:text-xl font-bold text-gray-900">
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
              </p>
              <p class="text-xs text-gray-500">
                {{ $produto->estoque }} un.
              </p>
            </div>
            
            <div class="mt-auto flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
                <a href="{{ route('show.detalhes', $produto->slug) }}"
                  class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-blue-700 transition-all duration-200 hover:shadow-md">
                  Detalhes
                </a>

                <form action="{{ route('site.addcarrinho') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                  @csrf
                  <input type="hidden" name="id" value="{{ $produto->id }}">
                  <input type="hidden" name="nome" value="{{ $produto->nome }}">
                  <input type="hidden" name="preco" value="{{ $produto->preco }}">
                  <input type="hidden" name="estoque" value="1" min="1">
                  <input type="hidden" name="imagem" value="{{ $produto->imagem }}">
                  <input type="hidden" name="slug" value="{{ $produto->slug }}">

                  <button type="submit"
                    class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition-all duration-200 hover:shadow-md active:scale-95">
                    Comprar
                  </button>
                </form>
            </div>

        </div>
      </div>
    @endforeach

  </div>
</div>

<div class="mt-10 flex justify-center px-4">
  @if(method_exists($produtos, 'links'))
    {{ $produtos->appends(request()->query())->links() }}
  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card-enter').forEach(el => observer.observe(el));
});
</script>

<style>
.card-enter { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
.card-enter.visible { opacity: 1; transform: translateY(0); }
.stagger-1 { transition-delay: 0.05s; }
.stagger-2 { transition-delay: 0.1s; }
.stagger-3 { transition-delay: 0.15s; }
.stagger-4 { transition-delay: 0.2s; }
.stagger-5 { transition-delay: 0.25s; }
.stagger-6 { transition-delay: 0.3s; }
</style>

@endif
