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
        $fingerprint = sha1(implode('|', [
            Auth::id(),
            $request->ip(),
            $request->userAgent(),
            $request->commentable_type,
            $request->commentable_id,
            $request->content,
        ]));

        // 🚫 evita comentário duplicado em 20s
        $alreadySent = Comment::where('fingerprint', $fingerprint)
            ->where('created_at', '>', now()->subSeconds(20))
            ->exists();

        if ($alreadySent) {
            return back()->with('aviso', 'Comentário duplicado. Aguarde 20 segundos antes de enviar novamente.');
        }

        $model = app($request->commentable_type)::findOrFail($request->commentable_id);

        $model->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'fingerprint' => $fingerprint,
        ]);

        return back()->with('sucesso', 'Comentário enviado!');
    }


    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para excluir este comentário.');
        }

        $comment->delete();

        return back()->with('sucesso', 'Comentário excluído com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este comentário.');
        }

        $comment->content = $request->content;
        $comment->save();

        return back()->with('sucesso', 'Comentário atualizado com sucesso!');
    }

}
