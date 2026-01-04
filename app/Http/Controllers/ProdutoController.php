<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function showProdutos()
    {
        $produtos = Produto::paginate(3);
  
        return view('produtos.index', compact('produtos'));
    
    }
}