<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string', 'min:2'],
        ]);

        $search = $request->input('search');

        $produtos = Produto::query()
            ->where('nome', 'like', "%{$search}%")
            ->whereHas('categoria', function ($query) {
                $query->where('ativo', true);
            })
            ->paginate(9)              // ✅ Paginação real
            ->withQueryString();       // ✅ Mantém ?search= na URL

        return view('produtos.search', compact('produtos', 'search'));
    }
}