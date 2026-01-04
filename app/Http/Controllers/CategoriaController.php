<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function showCategorias($id)
    {
        $categoria = Categoria::findOrFail($id);
        $produtos = Produto::where('categoria_id', $id)->paginate(4);


        return view('produtos.categorias', compact('produtos', 'categoria'));
    }
}
