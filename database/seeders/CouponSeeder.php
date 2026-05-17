<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $coupons = [
            [
                'code'               => 'BEMVINDO10',
                'type'               => 'percentage',
                'value'              => 10.00,
                'min_order_value'    => 50.00,
                'max_uses'           => 100,
                'used_count'         => 0,
                'max_uses_per_user'  => 1,
                'active'             => true,
                'starts_at'          => $now,
                'expires_at'         => $now->copy()->addMonths(6),
                'description'        => '10% de desconto na primeira compra acima de R$ 50,00',
            ],
            [
                'code'               => 'FRETEGRATIS',
                'type'               => 'fixed',
                'value'              => 15.00,
                'min_order_value'    => 100.00,
                'max_uses'           => 50,
                'used_count'         => 0,
                'max_uses_per_user'  => 1,
                'active'             => true,
                'starts_at'          => $now,
                'expires_at'         => $now->copy()->addMonths(3),
                'description'        => 'R$ 15,00 de desconto em pedidos acima de R$ 100,00',
            ],
            [
                'code'               => 'NIVER2025',
                'type'               => 'percentage',
                'value'              => 20.00,
                'min_order_value'    => 150.00,
                'max_uses'           => 30,
                'used_count'         => 0,
                'max_uses_per_user'  => 1,
                'active'             => true,
                'starts_at'          => Carbon::create(2025, 12, 1),
                'expires_at'         => Carbon::create(2025, 12, 31),
                'description'        => '20% de desconto no aniversário da loja',
            ],
            [
                'code'               => 'PRIMEIRACOMPRA',
                'type'               => 'fixed',
                'value'              => 10.00,
                'min_order_value'    => 0,
                'max_uses'           => 200,
                'used_count'         => 0,
                'max_uses_per_user'  => 1,
                'active'             => true,
                'starts_at'          => $now,
                'expires_at'         => $now->copy()->addYear(),
                'description'        => 'R$ 10,00 de desconto na primeira compra (sem valor mínimo)',
            ],
            [
                'code'               => 'VERAO2026',
                'type'               => 'percentage',
                'value'              => 15.00,
                'min_order_value'    => 80.00,
                'max_uses'           => 75,
                'used_count'         => 0,
                'max_uses_per_user'  => 2,
                'active'             => true,
                'starts_at'          => Carbon::create(2026, 1, 1),
                'expires_at'         => Carbon::create(2026, 3, 20),
                'description'        => '15% de desconto na coleção verão',
            ],
            [
                'code'               => 'FIDELIDADE',
                'type'               => 'percentage',
                'value'              => 5.00,
                'min_order_value'    => 0,
                'max_uses'           => null,
                'used_count'         => 0,
                'max_uses_per_user'  => null,
                'active'             => true,
                'starts_at'          => $now,
                'expires_at'         => null,
                'description'        => '5% de desconto para clientes fiéis (sem expiração)',
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::firstOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }

        $this->command->info('✓ ' . count($coupons) . ' cupons criados/verificados com sucesso!');
    }
}
