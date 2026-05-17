<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EfiCharge extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'charge_id',
        'payment_method',
        'total',
        'status',
        'boleto_url',
        'boleto_barcode',
        'boleto_expire_at',
        'card_mask',
        'installments',
        'payment_token',
        'payload_request',
        'payload_response',
        'notification_data',
        'refusal_reason',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'payload_request' => 'array',
            'payload_response' => 'array',
            'notification_data' => 'array',
            'paid_at' => 'datetime',
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

    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'approved', 'completed']);
    }
}
