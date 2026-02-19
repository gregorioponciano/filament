<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\Suporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowSuportController extends Controller
{
    public function showSuporte() {
        return view('suporte.index');
    }

    public function showChamados() {
        $chamados = Suporte::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('suporte.chamados', compact('chamados'));
    }

    public function showChamadoDetalhes(Suporte $suporte)
    {
        // Garante que o usuário só pode ver seus próprios chamados
        if ($suporte->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $suporte->load('user');

        return view('suporte.detalhes', compact('suporte'));
    }
}
