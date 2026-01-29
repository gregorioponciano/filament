<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'fingerprint',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }





public function votes()
{
    return $this->hasMany(CommentVote::class);
}

public function likesCount()
{
    return $this->votes()->where('vote', 1)->count();
}

public function dislikesCount()
{
    return $this->votes()->where('vote', -1)->count();
}

public function userVote()
{
    return $this->votes()
        ->where('user_id', Auth::id())
        ->value('vote');
}

}