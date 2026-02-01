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
        $produto = Produto::where('slug', $slug)->whereHas('categoria', function ($query) {
            $query->where('ativo', true);
        })->firstOrFail();
        $categorias = Categoria::where('ativo', true)->get();

        return view('produtos.detalhes', compact('produto', 'categorias'));
    }
}