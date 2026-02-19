<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalhesController extends Controller
{
    public function showDetalhes($slug)
    {
        $produto = Produto::where('slug', $slug)->whereHas('categoria', function ($query) {
            $query->where('ativo', true);
        })->firstOrFail();
        $categorias = Categoria::where('ativo', true)->get();

        $quantidadeNoCarrinho = 0;
        if (Auth::check()) {
            $itemNoCarrinho = Cart::session(Auth::id())->get($produto->id);
            if ($itemNoCarrinho) {
                $quantidadeNoCarrinho = $itemNoCarrinho->quantity;
            }
        }

        return view('produtos.detalhes', compact('produto', 'categorias', 'quantidadeNoCarrinho'));
    }
}