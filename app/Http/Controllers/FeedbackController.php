<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create($id)
    {
        $produto = Produto::where('id', $id)->whereHas('categoria', function ($query) {
            $query->where('ativo', true);
        })->firstOrFail();
        
        return view('produtos.feedback', compact('produto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verifica se o usuário já avaliou este produto (opcional, remova se quiser permitir múltiplas)
        $existingFeedback = Feedback::where('user_id', Auth::id())
            ->where('produto_id', $request->produto_id)
            ->first();

        if ($existingFeedback) {
            return back()->with('aviso', 'Você já avaliou este produto.');
        }

        Feedback::create([
            'user_id' => Auth::id(),
            'produto_id' => $request->produto_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redireciona para a página de detalhes do produto após avaliar
        return redirect()->route('show.detalhes', $request->slug ?? Produto::find($request->produto_id)->slug)->with('success', 'Obrigado pelo seu feedback!');
    }
}
