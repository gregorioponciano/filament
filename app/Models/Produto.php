<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'preco',
        'imagem',
        'estoque',
        'user_id',
        'categoria_id',
        

    ];
       public function categoria()
    {// procura no banco o relacionamento e mostra qual categoria ex:(  {{ $produto->categoria->nome ?? 'Categoria' }} )
        return $this->belongsTo(Categoria::class);  
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {

        return $this->imagem ? asset('storage/' . $this->imagem) : null;
    }
}
