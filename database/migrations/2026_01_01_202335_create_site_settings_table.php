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
            $table->string('primary_color')->default('#2563eb'); // azul
            $table->string('secondary_color')->default('#6c757');
            $table->string('text_color')->default('#2563eb');
            $table->string('bg_color')->default('#ffffff');
            $table->string('font_family')->default('Inter');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
