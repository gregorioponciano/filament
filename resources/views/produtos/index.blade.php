@if(isset($produtos) && $produtos->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

    @foreach ($produtos as $produto)

      <div class="group relative flex flex-col overflow-hidden rounded-xl  border border-gray-500 shadow-sm hover:shadow-md transition-all duration-300">

        {{-- IMAGEM COM OLHO --}}
        <div class=" h-auto w-full overflow-hidden ">
          <img 
        src="{{ asset('storage/' . $produto->imagem) }}" 
        alt="{{ $produto->nome }}"
        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"/>
        </div>

        <div class="flex flex-1 flex-col p-5 bg-card-primary">
            {{-- CATEGORIA --}}
            <div class="mb-2 flex items-center justify-between">
                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                  {{ $produto->categoria->nome ?? 'Geral' }}
                </span>
                <form action="{{ route('favorites.toggle') }}" method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <button type="submit" class="cursor-pointer transition-colors {{ Auth::check() && Auth::user()->favorites->contains('id', $produto->id) ? 'text-red-600' : 'text-gray-400 hover:text-red-600' }}">
                        <span class="material-symbols-outlined">favorite</span>
                    </button>
                </form>
            </div>

            {{-- NOME --}}
            <h3 class="text-lg font-bold text-text-primary mb-1">
              {{ \Illuminate\Support\Str::limit($produto->nome, 40) }}
            </h3>

            {{-- DESCRIÇÃO --}}
            <p class="text-sm text-gray-500 mb-4 flex-1">
              {{ \Illuminate\Support\Str::limit($produto->descricao, 60) }}
            </p>

            <p class="text-xl font-bold text-text-price">
              R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>
            
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                <a href="{{ route('show.detalhes', $produto->slug) }}"class="rounded-lg bg-button-secondary px-4 py-2.5 hover:bg-hover-secondary transition cursor-pointer" >Detalhes</a>

                <form action="{{ route('site.addcarrinho') }}" method="POST" enctype="multipart/form-data">
                @csrf
                  <input type="hidden" name="id" value="{{ $produto->id }}">
                  <input type="hidden" name="nome" value="{{ $produto->nome }}">
                  <input type="hidden" name="preco" value="{{ $produto->preco }}">
                  <input type="hidden" name="estoque" value="1" min="1">
                  <input type="hidden" name="imagem" value="{{ $produto->imagem }}">
                  <input type="hidden" name="slug" value="{{ $produto->slug }}">
                  <input type="submit" value="comprar" class="rounded-lg bg-button-primary px-4 py-2.5 hover:bg-hover-primary transition cursor-pointer">
                </form>
            </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="mt-8 flex justify-center">
  @if(method_exists($produtos, 'links'))
    {{ $produtos->appends(request()->query())->links() }}
  @endif
</div>




@endif
