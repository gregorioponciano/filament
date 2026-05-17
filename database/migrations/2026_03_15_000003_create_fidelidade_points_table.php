<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cria a tabela de pontos de fidelidade.
     * Regra: R$ 1,00 = 1 ponto.
     * Os pontos podem ser acumulados (earn) ou resgatados (redeem).
     */
    public function up(): void
    {
        Schema::create('fidelidade_points', function (Blueprint $table) {
            $table->id();

            // Relacionamento com usuário
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Quantidade de pontos (positivo para acúmulo, negativo para resgate)
            $table->integer('points');

            // Tipo: earn (ganhou), redeem (resgatou), expired (expirou), admin (ajuste manual)
            $table->string('type')->default('earn');

            // Origem: payment, coupon, manual
            $table->string('source')->default('payment');

            // Descrição do movimento
            $table->string('description')->nullable();

            // Relacionamentos opcionais
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

            // Índices
            $table->index('type');
            $table->index('source');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fidelidade_points');
    }
};
