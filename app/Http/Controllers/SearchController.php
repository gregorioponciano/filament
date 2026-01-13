<?php

namespace App\Http\Controllers;

use App\Models\Produto;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Validação simples
        $request->validate([
            'search' => ['required', 'string', 'min:2'],
        ]);

        $search = $request->input('search');

        // Busca no banco
        $produtos = Produto::query()
            ->where('nome', 'like', "%{$search}%")
            ->limit(20)
            ->get();
            

        return view('produtos.search', compact('produtos', 'search'));
    }
}
