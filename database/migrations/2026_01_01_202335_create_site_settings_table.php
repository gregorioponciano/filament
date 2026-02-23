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
            $table->string('bg_primary')->default('#FFFFFF'); 
            $table->string('bg_secondary')->default('#000000');         
            $table->string('primary_color')->default('#FFFFFF');  
            $table->string('secondary_color')->default('#000000'); 
            $table->string('menu_primary')->default('#FFFFFF');
            $table->string('menu_secondary')->default('#000000');  
            $table->string('card_primary')->default('#FFFFFF');
            $table->string('card_secondary')->default('#000000'); 
            $table->string('link_primary')->default('#FFFFFF');     
            $table->string('link_secondary')->default('#000000');
            $table->string('h1_primary')->default('#FFFFFF');
            $table->string('h1_secondary')->default('#000000');       
            $table->string('h2_primary')->default('#FFFFFF');
            $table->string('h2_secondary')->default('#000000');   
            $table->string('h3_primary')->default('#FFFFFF');
            $table->string('h3_secondary')->default('#000000');    
            $table->string('text_primary')->default('#FFFFFF');     
            $table->string('text_secondary')->default('#000000');  
            $table->string('price_primary')->default('#FFFFFF');    
            $table->string('price_secondary')->default('#000000'); 
            $table->string('button_primary')->default('#FFFFFF');   
            $table->string('button_secondary')->default('#F0B100'); 
            $table->string('input_primary')->default('#FFFFFF'); 
            $table->string('input_secondary')->default('#000000');
            $table->string('hover_primary')->default('#0B309A');    
            $table->string('hover_secondary')->default('#C79100');  
            $table->string('border_primary')->default('#FFFFFF');   
            $table->string('border_secondary')->default('#000000'); 
            $table->string('footer_color')->default('#FFFFFF');     
            $table->string('footer_text_color')->default('#000000');
            $table->string('font_family')->default('Inter');
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
