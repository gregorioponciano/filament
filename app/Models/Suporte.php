<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suporte extends Model
{
    protected $fillable = [
        'user_id',
        'assunto',
        'mensagem',
        'resposta',
        'status',
        'lido',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
