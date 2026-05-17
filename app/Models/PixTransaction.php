<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PixTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'txid',
        'status',
        'valor',
        'qrcode',
        'qrcode_base64',
        'location',
        'end_to_end_id',
        'pix_copia_cola',
        'payload',
        'webhook_received',
        'pago_em',
        'expiracao',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'payload' => 'array',
            'webhook_received' => 'array',
            'pago_em' => 'datetime',
            'expiracao' => 'datetime',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPago(): bool
    {
        return $this->status === 'CONCLUIDA';
    }

    public function isExpirada(): bool
    {
        return $this->status === 'REMOVIDA_PELO_PSP';
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'ATIVA');
    }
}
