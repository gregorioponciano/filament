

<button onclick="window.history.go(-1)"><i class="material-icons">arrow_back</i></button>
<div class="">
    <div class="">
          <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" class="">
            <h3>{{ $produto->nome }}</h3>
            <h5>R$ {{ number_format($produto->preco, 2, ',', '.') }}</h5>
             <span class="">{{ \Illuminate\Support\Str::limit($produto->nome, 32) }}</span>

            <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $produto->id }}">
            <input type="hidden" name="nome" value="{{ $produto->nome }}">
            <input type="hidden" name="price" value="{{ number_format($produto->preco, 2, ',', '.') }}">
            <input type="number" name="qnt" value="1" min="1">
            <input type="hidden" name="image" value="{{ $produto->imagem }}">
            <input type="submit" value="comprar" class="btn orange btn-large">
            </form>
    </div>

</div>