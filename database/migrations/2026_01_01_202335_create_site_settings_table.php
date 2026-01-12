<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->default('#3294cd'); // azul
            $table->string('secondary_color')->default('#ef8d32');
            $table->string('text_color')->default('#2563eb');
            $table->string('bg_color')->default('#ff0f00');
            $table->string('border_color')->default('#000000');
            $table->string('link_color')->default('#4f38f6');
            $table->string('hover_color')->default('#000000');
            $table->string('footer_color')->default('#111111');
            $table->string('footer_text_color')->default('#ffffff');
            $table->string('font_family')->default('Inter');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
