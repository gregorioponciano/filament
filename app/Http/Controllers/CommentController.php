<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000',
            'commentable_type' => 'required',
            'commentable_id' => 'required',
        ]);

        $model = app($request->commentable_type)::findOrFail($request->commentable_id);

        $model->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('sucesso', 'Comentário enviado!');
    }
}

