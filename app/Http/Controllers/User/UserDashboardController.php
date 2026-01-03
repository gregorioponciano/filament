<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function dashboard() {
        $categorias = Categoria::all();
        $produtos = Produto::paginate(3);
        return view('user.dashboard', compact('categorias', 'produtos'));
    }
}
