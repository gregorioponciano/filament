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
            $table->string('bg_color')->default('#F5F3FF');         
            $table->string('primary_color')->default('#FACC15');  
            $table->string('secondary_color')->default('#44474c'); 
            $table->string('card_primary')->default('#212121');
            $table->string('card_secondary')->default('#C4B5FD'); 
            $table->string('link_primary')->default('#ffff00');     
            $table->string('link_secondary')->default('#9333EA');
            $table->string('h1_color')->default('#111827');       
            $table->string('h2_color')->default('#ffff00');   
            $table->string('h3_color')->default('#ffff00');    
            $table->string('text_primary')->default('#9e97a6');     
            $table->string('text_secondary')->default('#ffff00');   
            $table->string('text_price')->default('#0ff000');
            $table->string('button_primary')->default('#FACC15');   
            $table->string('button_secondary')->default('#0ff000'); 
            $table->string('input_primary')->default('#ffff00'); 
            $table->string('input_secondary')->default('#6D28D9');
            $table->string('hover_primary')->default('#EAB308');    
            $table->string('hover_secondary')->default('#0faa00');  
            $table->string('border_primary')->default('#E5E7EB');   
            $table->string('border_secondary')->default('#C4B5FD'); 
            $table->string('footer_color')->default('#2E1065');     
            $table->string('footer_text_color')->default('#EDE9FE');
            $table->string('font_family')->default('Inter');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
