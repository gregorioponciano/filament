<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalhesController extends Controller
{
    public function showDetalhes($slug)
    {
 $produto = Produto::where('slug', $slug)->firstOrFail();
        $categorias = Categoria::all();

        return view('produtos.detalhes', compact('produto', 'categorias'));
    }
}