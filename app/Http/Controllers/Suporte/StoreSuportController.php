<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\Suporte;
use Illuminate\Http\Request;

class StoreSuportController extends Controller
{
    public function storeSuporte(Request $request)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        // Verifica se já existe uma mensagem idêntica enviada nos últimos 5 minutos
        $duplicado = Suporte::where('user_id', $request->user()->id)
            ->where('assunto', $validated['assunto'])
            ->where('mensagem', $validated['mensagem'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($duplicado) {
            return redirect()->route('show.suporte')->with('erro', 'Você já enviou esta mensagem recentemente.');
        }

        $suporte = new Suporte();
        $suporte->user_id = $request->user()->id;
        $suporte->assunto = $validated['assunto'];
        $suporte->mensagem = $validated['mensagem'];
        $suporte->save();

        return redirect()->route('show.suporte')->with('suporte', 'Mensagem enviada com sucesso!');
    }
}
