<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model FidelidadeLog
 *
 * Registra o histórico de movimentações de pontos de fidelidade.
 * Cada linha representa uma transação: ganho, resgate, ajuste manual ou expiração.
 * O saldo atual do usuário fica na coluna `users.points` para performance.
 */
class FidelidadeLog extends Model
{
    protected $table = 'fidelidade_logs';

    protected $fillable = [
        'user_id',
        'points',
        'balance_after',
        'type',
        'source',
        'description',
        'payment_id',
        'order_id',
        'adjusted_by',
    ];

    protected $casts = [
        'points' => 'integer',
        'balance_after' => 'integer',
    ];

    /**
     * Relacionamento: Um log pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Um log pode estar vinculado a um pagamento.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Relacionamento: Um log pode estar vinculado a um pedido.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relacionamento: Admin que ajustou manualmente (quando type = admin).
     */
    public function adjustedBy()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    /**
     * Escopo: Apenas registros de ganho de pontos.
     */
    public function scopeEarned($query)
    {
        return $query->where('type', 'earn');
    }

    /**
     * Escopo: Apenas registros de resgate de pontos.
     */
    public function scopeRedeemed($query)
    {
        return $query->where('type', 'redeem');
    }

    /**
     * Escopo: Apenas registros de ajuste manual.
     */
    public function scopeManual($query)
    {
        return $query->where('type', 'admin');
    }
}
