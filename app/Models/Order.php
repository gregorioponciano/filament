<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $fillable = [
        'user_id',
        'endereco_id',
        'total',
        'status',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function endereco()
    {
        // Relacionamento: Um pedido pertence a um endereço
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }

    protected static function booted(): void
    {
        static::saving(function (Order $order) {
            // Copia se for um novo pedido OU se o endereço mudou (isDirty)
            if ($order->endereco_id && ($order->isDirty('endereco_id') || !$order->exists) && $endereco = Endereco::find($order->endereco_id)) {
                $order->rua = $endereco->rua;
                $order->numero = $endereco->numero;
                $order->complemento = $endereco->complemento;
                $order->bairro = $endereco->bairro;
                $order->cidade = $endereco->cidade;
                $order->estado = $endereco->estado;
                $order->cep = $endereco->cep;
            }
        });
    }

    public function getEnderecoCompletoAttribute()
    {
        if ($this->rua) {
            return "{$this->rua}, {$this->numero} - {$this->bairro}, {$this->cidade} - {$this->estado}, CEP: {$this->cep}";
        }

        return $this->endereco?->endereco_completo;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
