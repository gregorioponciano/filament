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

    public function searchProdutos(Request $request)
    {
        $search = $request->input('search');
        
        $produtos = Produto::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', '%' . $search . '%');
            })
            ->paginate(3)
            ->withQueryString();

        return view('produtos.index', compact('produtos'));
    }
}
