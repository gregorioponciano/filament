<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('efi_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('charge_id')->nullable()->index();
            $table->string('payment_method'); // boleto, credit_card
            $table->decimal('total', 10, 2);
            $table->string('status')->default('new');
            $table->string('boleto_url')->nullable();
            $table->string('boleto_barcode')->nullable();
            $table->string('boleto_expire_at')->nullable();
            $table->string('card_mask')->nullable();
            $table->integer('installments')->default(1);
            $table->string('payment_token')->nullable();
            $table->json('payload_request')->nullable();
            $table->json('payload_response')->nullable();
            $table->json('notification_data')->nullable();
            $table->string('refusal_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // order_created, payment_confirmed, support_reply, etc
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('icon')->default('notifications');
            $table->string('color')->default('blue');
            $table->string('action_url')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('efi_charges');
        Schema::dropIfExists('notifications');
    }
};
