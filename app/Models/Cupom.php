<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'cupons';

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_value',
        'max_uses',
        'used_count',
        'product_id',
        'starts_at',
        'expires_at',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_value' => 'decimal:2',
            'active' => 'boolean',
            'starts_at' => 'date',
            'expires_at' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Produto::class, 'product_id');
    }

    public function isValid(): bool
    {
        if (!$this->active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->starts_at && now()->startOfDay()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->startOfDay()->gt($this->expires_at)) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal, ?float $productPrice = null): float
    {
        if ($this->product_id && $productPrice !== null) {
            $base = $productPrice;
        } else {
            $base = $subtotal;
        }

        if ($this->min_value && $base < $this->min_value) return 0;

        if ($this->type === 'percentage') {
            return round($base * ($this->value / 100), 2);
        }

        return min($this->value, $base);
    }
}
