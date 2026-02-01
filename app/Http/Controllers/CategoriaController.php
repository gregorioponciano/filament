<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function showCategorias($slug)
    {
        $categoria = Categoria::where('slug', $slug)->where('ativo', true)->firstOrFail();
        $produtos = Produto::where('categoria_id', $categoria->id)->paginate(4);


        return view('produtos.categorias', compact('produtos', 'categoria'));
    }
}
