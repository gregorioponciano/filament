<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Cria a tabela `fidelidade_logs` que substitui a antiga `fidelidade_points`.
     * Esta tabela registra o histórico completo de movimentações de pontos:
     * - Ganhos (earn): quando o usuário faz um pagamento
     * - Resgates (redeem): quando o usuário usa pontos como desconto
     * - Ajustes manuais (admin): quando o administrador altera o saldo
     * - Expiração (expired): quando pontos expiram
     *
     * O saldo atual fica armazenado na coluna `users.points` para consultas rápidas.
     */
    public function up(): void
    {
        // Remove tabela antiga se existir
        Schema::dropIfExists('fidelidade_points');

        Schema::create('fidelidade_logs', function (Blueprint $table) {
            $table->id();

            // Usuário dono dos pontos
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Quantidade de pontos movimentados (sempre positivo)
            $table->integer('points');

            // Saldo do usuário APÓS esta movimentação (consistência e auditoria)
            $table->integer('balance_after')->nullable()
                ->comment('Saldo do usuário após esta movimentação');

            // Tipo: earn (ganhou), redeem (resgatou), expired (expirou), admin (ajuste manual)
            $table->string('type')->default('earn');

            // Origem: payment, coupon, manual, order_cancellation
            $table->string('source')->default('payment');

            // Descrição legível do movimento
            $table->string('description')->nullable();

            // Relacionamentos opcionais para rastreabilidade
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();

            // ID do admin que fez o ajuste (se for manual)
            $table->foreignId('adjusted_by')->nullable()->constrained('users')->nullOnDelete()
                ->comment('ID do administrador que realizou o ajuste (quando type = admin)');

            $table->timestamps();

            // Índices para consultas eficientes
            $table->index('user_id');
            $table->index('type');
            $table->index('source');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fidelidade_logs');

        // Recria a tabela antiga para rollback seguro
        Schema::create('fidelidade_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('points');
            $table->string('type')->default('earn');
            $table->string('source')->default('payment');
            $table->string('description')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index('type');
            $table->index('source');
            $table->index('user_id');
        });
    }
};
