<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE payments MODIFY pix_qr_code_url TEXT NULL COMMENT "URL da imagem do QR Code PIX"');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE payments MODIFY pix_qr_code_url VARCHAR(255) NULL COMMENT "URL da imagem do QR Code PIX"');
    }
};
