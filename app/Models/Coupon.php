<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_value',
        'max_uses',
        'used_count',
        'max_uses_per_user',
        'active',
        'starts_at',
        'expires_at',
        'description',
        'created_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Retorna o nome do tipo em português.
     */
    public function getTipoDescontoAttribute(): string
    {
        return $this->type === 'percentage' ? 'Percentual (%)' : 'Valor Fixo (R$)';
    }

    /**
     * Retorna o valor formatado do desconto.
     */
    public function getValorFormatadoAttribute(): string
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        }
        return 'R$ ' . number_format($this->value, 2, ',', '.');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Verifica se o cupom é válido para uso.
     */
    public function isValid(?float $orderValue = null, ?int $userId = null): bool
    {
        if (!$this->active) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($orderValue && $this->min_order_value && $orderValue < $this->min_order_value) {
            return false;
        }

        if ($userId && $this->max_uses_per_user) {
            $userUses = Payment::where('coupon_id', $this->id)
                ->where('user_id', $userId)
                ->count();
            if ($userUses >= $this->max_uses_per_user) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calcula o valor do desconto para um determinado total.
     */
    public function calculateDiscount(float $total): float
    {
        if ($this->type === 'percentage') {
            return round($total * ($this->value / 100), 2);
        }

        return min($this->value, $total);
    }
}
