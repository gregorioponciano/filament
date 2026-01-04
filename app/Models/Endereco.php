<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Endereco extends Model
{

      use HasFactory;

        protected $fillable = [
        'user_id',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEnderecoCompletoAttribute()
    {
        return "{$this->rua}, {$this->numero} - {$this->bairro}, {$this->cidade} - {$this->estado}, CEP: {$this->cep}";
    }

}
