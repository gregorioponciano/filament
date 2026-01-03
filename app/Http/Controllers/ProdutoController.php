<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function showProdutos()
    {
        $produtos = Produto::paginate(3);
  
        return view('produtos.index', compact('produtos'));
    
    }
}