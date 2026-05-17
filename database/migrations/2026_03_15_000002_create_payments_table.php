<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cria a tabela de pagamentos integrada à Efí Pay.
     * Suporta PIX, Cartão de Crédito e Boleto.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relacionamento com pedido e usuário
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // ID da transação na Efí Pay (charge_id)
            $table->string('transaction_id')->nullable()->unique()->comment('ID da cobrança na Efí Pay');

            // Método de pagamento: pix, credit_card, boleto
            $table->string('payment_method');

            // Valor total do pagamento
            $table->decimal('amount', 10, 2);

            // Status do pagamento: pending, paid, cancelled, refunded, expired
            $table->string('status')->default('pending');

            // Dados específicos do PIX
            $table->text('pix_qr_code')->nullable()->comment('Código PIX Copia e Cola (brcode)');
            $table->string('pix_qr_code_url')->nullable()->comment('URL da imagem do QR Code PIX');

            // Dados específicos do Boleto
            $table->string('boleto_url')->nullable()->comment('URL do PDF do boleto');
            $table->string('boleto_barcode')->nullable()->comment('Código de barras do boleto');

            // Dados do cartão de crédito (apenas últimos 4 dígitos, mascarado)
            $table->json('credit_card_details')->nullable()->comment('Dados mascarados do cartão de crédito');

            // Cupom aplicado (se houver)
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Valor do desconto aplicado');
            $table->decimal('points_discount', 10, 2)->default(0)->comment('Desconto por pontos de fidelidade');

            // Metadata adicional (resposta completa da API)
            $table->json('metadata')->nullable()->comment('Resposta completa da API Efí Pay');

            // Datas importantes
            $table->timestamp('paid_at')->nullable()->comment('Data da confirmação do pagamento');
            $table->timestamp('expires_at')->nullable()->comment('Data de expiração da cobrança');

            $table->timestamps();

            // Índices para performance
            $table->index('status');
            $table->index('payment_method');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
