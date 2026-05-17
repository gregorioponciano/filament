<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
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

        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pago', 'concluido'])
            ->whereHas('items', function ($q) use ($id) {
                $q->where('produto_id', $id);
            })
            ->exists();

        return view('produtos.feedback', compact('produto', 'hasPurchased'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pago', 'concluido'])
            ->whereHas('items', function ($q) use ($request) {
                $q->where('produto_id', $request->produto_id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('aviso', 'Você só pode avaliar produtos que você comprou.');
        }

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

        return redirect()->route('show.detalhes', $request->slug ?? Produto::find($request->produto_id)->slug)->with('success', 'Obrigado pelo seu feedback!');
    }
}
