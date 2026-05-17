<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pix_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('txid')->unique();
            $table->string('status')->default('ATIVA');
            $table->decimal('valor', 10, 2);
            $table->string('qrcode')->nullable();
            $table->text('qrcode_base64')->nullable();
            $table->string('location')->nullable();
            $table->string('end_to_end_id')->nullable()->unique();
            $table->string('pix_copia_cola')->nullable();
            $table->json('payload')->nullable();
            $table->json('webhook_received')->nullable();
            $table->timestamp('pago_em')->nullable();
            $table->timestamp('expiracao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pix_transactions');
    }
};
