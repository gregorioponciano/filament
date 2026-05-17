<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cria a tabela de cupons de desconto.
     * A validação e o valor do desconto são processados exclusivamente no backend
     * para evitar manipulação pelo cliente.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // Código único do cupom (inserido pelo usuário)
            $table->string('code')->unique();

            // Tipo: percentage (percentual) ou fixed (valor fixo)
            $table->string('type')->default('percentage');

            // Valor do desconto
            $table->decimal('value', 10, 2);

            // Valor mínimo do pedido para aplicar o cupom
            $table->decimal('min_order_value', 10, 2)->nullable();

            // Limites de uso
            $table->integer('max_uses')->nullable()->comment('Limite total de usos');
            $table->integer('used_count')->default(0)->comment('Quantas vezes foi usado');
            $table->integer('max_uses_per_user')->nullable()->comment('Limite de usos por usuário');

            // Controle de ativação
            $table->boolean('active')->default(true);

            // Período de validade
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Descrição do cupom
            $table->string('description')->nullable();

            // Quem criou o cupom
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Índices
            $table->index('code');
            $table->index('active');
            $table->index(['starts_at', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
