<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentVoteController extends Controller
{
    public function vote(Request $request, Comment $comment)
    {
        $request->validate([
            'vote' => 'required|in:1,-1'
        ]);

        $userId = Auth::id();

        $vote = $comment->votes()
            ->where('user_id', $userId)
            ->first();

        if ($vote) {
            // clicou no mesmo botão → remove
            if ($vote->vote == $request->vote) {
                $vote->delete();
            } else {
                // troca like ↔ dislike
                $vote->update([
                    'vote' => $request->vote
                ]);
            }
        } else {
            // cria voto
            $comment->votes()->create([
                'user_id' => $userId,
                'vote' => $request->vote
            ]);
        }

        return back();
    }
}
