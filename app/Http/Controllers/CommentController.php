<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id'   => 'required|integer',
            'content'          => 'required|min:3|max:1000',
        ]);

        // 🔐 fingerprint único
        $fingerprint = sha1(
            Auth::id() .
            $request->ip() .
            $request->userAgent() .
            $request->content .
            $request->commentable_id .
            $request->commentable_type
        );

        // 🚫 evita comentário duplicado em 20s
        $alreadySent = Comment::where('fingerprint', $fingerprint)
            ->where('created_at', '>', now()->subSeconds(20))
            ->exists();

        if ($alreadySent) {
            return back()->with('aviso', 'comentario duplicado aguarde 20 segundos.');
        }
   $model = app($request->commentable_type)::findOrFail($request->commentable_id);

        $model->comments()->create([

            'user_id' => Auth::id(),
            'content' => $request->content,
            'fingerprint' => $fingerprint,
        ])->commentable()->associate(
            $request->commentable_type::findOrFail($request->commentable_id)
        )->save();

        return back()->with('sucesso', 'Comentário enviado!');
    }
}

