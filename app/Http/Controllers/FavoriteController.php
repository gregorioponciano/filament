<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
        public function toggle(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
        ]);

        $user = Auth::user();
        $result = $user->favorites()->toggle($request->produto_id);

        return back();
    }

    public function index()
    {
        $produtos = Auth::user()
            ->favorites()
            ->whereHas('categoria', function ($query) {
                $query->where('ativo', true);
            })
            ->paginate(9);

        return view('produtos.favorites', compact('produtos'));
    }
}
