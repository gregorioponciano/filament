<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE payments MODIFY boleto_url TEXT NULL COMMENT "URL do PDF do boleto"');
        DB::statement('ALTER TABLE payments MODIFY boleto_barcode TEXT NULL COMMENT "Código de barras do boleto"');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE payments MODIFY boleto_url VARCHAR(255) NULL COMMENT "URL do PDF do boleto"');
        DB::statement('ALTER TABLE payments MODIFY boleto_barcode VARCHAR(255) NULL COMMENT "Código de barras do boleto"');
    }
};
