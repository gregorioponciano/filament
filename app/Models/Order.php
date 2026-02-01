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
}
