<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'preco',
        'imagem',
        'estoque',
        'categoria_id',
        

    ];
}
