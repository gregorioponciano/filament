<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @deprecated Use FidelidadeLog para novos desenvolvimentos.
 *             Esta classe permanece para compatibilidade com código legado,
 *             mas agora aponta para a tabela 'fidelidade_logs'.
 */
class FidelidadePoint extends Model
{
    protected $table = 'fidelidade_logs';

    protected $fillable = [
        'user_id',
        'points',
        'type',
        'source',
        'description',
        'payment_id',
        'order_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeEarned($query)
    {
        return $query->where('type', 'earn');
    }

    public function scopeRedeemed($query)
    {
        return $query->where('type', 'redeem');
    }
}
