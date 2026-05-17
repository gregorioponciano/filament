<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adiciona a coluna `points` na tabela `users` para armazenar
     * o saldo atual de pontos de fidelidade (R$ 1,00 = 1 ponto).
     *
     * Migra os dados existentes da tabela `fidelidade_points` para o novo saldo.
     * Remove a tabela antiga `fidelidade_points`.
     */
    public function up(): void
    {
        // 1. Adiciona coluna points na tabela users
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('role')
                ->comment('Saldo atual de pontos de fidelidade (R$ 1,00 = 1 ponto)');
        });

        // 2. Migra saldo existente da tabela antiga (se houver dados)
        if (Schema::hasTable('fidelidade_points')) {
            $users = DB::table('fidelidade_points')
                ->select('user_id')
                ->selectRaw('SUM(CASE WHEN type = "earn" THEN points ELSE 0 END) - SUM(CASE WHEN type = "redeem" THEN points ELSE 0 END) as balance')
                ->groupBy('user_id')
                ->get();

            foreach ($users as $user) {
                DB::table('users')
                    ->where('id', $user->user_id)
                    ->update(['points' => max(0, (int) $user->balance)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }
};
