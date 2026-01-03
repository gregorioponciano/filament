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
       public function categoria()
    {// procura no banco o relacionamento e mostra qual categoria ex:(  {{ $produto->categoria->nome ?? 'Categoria' }} )
        return $this->belongsTo(Categoria::class);  
    }
}
