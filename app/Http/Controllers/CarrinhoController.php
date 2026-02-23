<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class CarrinhoController extends Controller
{
 // Adicionar produto ao carrinho
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nome' => 'required',
            'preco' => 'required',
            'estoque' => 'required|numeric|min:1',
            'imagem' => 'nullable',
            'slug' => 'required',
        ]);

        // Evita duplo clique: bloqueia requisições duplicadas para o mesmo produto por 3 segundos
        $limiterKey = 'cart_add_' . Auth::id() . '_' . $request->id;
        if (RateLimiter::tooManyAttempts($limiterKey, 1)) {
            return redirect()->route('show.carrinho');
        }
        RateLimiter::hit($limiterKey, 3);

        // Verificar estoque real no banco antes de adicionar
        $produto = Produto::find($request->id);
        $quantidadeSolicitada = abs($request->input('estoque', 1));

        $itemNoCarrinho = Cart::session(Auth::id())->get($request->id);
        $quantidadeJaNoCarrinho = $itemNoCarrinho ? $itemNoCarrinho->quantity : 0;

        $quantidadeTotalDesejada = $quantidadeJaNoCarrinho + $quantidadeSolicitada;

        if (!$produto || $produto->estoque < $quantidadeTotalDesejada) {
            if ($quantidadeJaNoCarrinho > 0) {
                $disponivel = $produto ? max(0, $produto->estoque - $quantidadeJaNoCarrinho) : 0;
                return redirect()->back()->with('erro', 'Quantidade indisponível! Você já tem ' . $quantidadeJaNoCarrinho . ' no carrinho. Restam apenas ' . $disponivel . ' em estoque para este produto.');
            }
            return redirect()->back()->with('erro', 'Quantidade indisponível! Temos apenas ' . ($produto->estoque ?? 0) . ' em estoque.');
        }

        Cart::session(Auth::id())->add(array(
    'id' => $request->id,
    'name' => $request->nome,
    'price' => $request->preco,
    'quantity' => abs($request->input('estoque', 1)),
    'attributes' => array(
        'image' => $request->imagem,
        'slug' => $request->slug,
    ),

));

       return redirect()->route('show.carrinho')->with('sucesso', 'Produto adicionado ao carrinho!');

    }

    // Listar itens do carrinho
    public function showCarrinho()
    {
        $itens = Cart::session(Auth::id())->getContent();
        // Busca os produtos no banco baseados nos IDs do carrinho para ter acesso ao estoque atualizado
        $produtos = Produto::whereIn('id', $itens->pluck('id'))->get();
        
        return view('produtos.carrinho', compact('itens', 'produtos'));
    }


    // Remover item do carrinho
    public function remover($id)
    {
        Cart::session(Auth::id())->remove($id);
        return redirect()->back()->with('sucesso', 'Produto removido!');
    }

    // Limpar carrinho
    public function limpar()
    {
        Cart::session(Auth::id())->clear();
        return redirect()->back()->with('aviso', 'Carrinho limpo!');
    }

    public function atualizar(Request $request)
     {
        // Verificar estoque real no banco antes de atualizar a quantidade
        $produto = Produto::find($request->id);
        $novaQuantidade = abs($request->estoque);

        if (!$produto || $produto->estoque < $novaQuantidade) {
            return redirect()->back()->with('erro', 'Quantidade indisponível! Temos apenas ' . ($produto->estoque ?? 0) . ' em estoque.');
        }

        Cart::session(Auth::id())->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => abs($request->estoque),
            ],
        ]);
        
        return redirect()->route('show.carrinho')->with('sucesso', 'Produto atualizado ao carrinho!');
    }

}