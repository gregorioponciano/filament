<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EfiPayConfigSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que o diretório de certificados existe
        $certsPath = storage_path('app/certs');
        if (!is_dir($certsPath)) {
            mkdir($certsPath, 0755, true);
            $this->command->info('✓ Diretório ' . $certsPath . ' criado.');
        }

        // Garante que o arquivo de log existe
        $logDir = storage_path('logs');
        $logFile = $logDir . '/efipay.log';
        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
            $this->command->info('✓ Arquivo de log ' . $logFile . ' criado.');
        }

        // Aviso sobre configuração pendente
        $clientId = config('efipay.client_id');
        if (empty($clientId)) {
            $this->command->warn('⚠ Atenção: Configure as credenciais da Efí Pay no .env:');
            $this->command->warn('   EFIPAY_CLIENT_ID, EFIPAY_CLIENT_SECRET e EFIPAY_PIX_KEY');
        }

        // Aviso sobre certificado
        $certPath = config('efipay.cert_path');
        $keyPath  = config('efipay.chave_path');

        if ($certPath && !file_exists($certPath)) {
            $this->command->warn('⚠ Certificado PIX não encontrado em: ' . $certPath);
            $this->command->warn('   Coloque o arquivo de certificado neste local.');
        }

        if ($keyPath && !file_exists($keyPath)) {
            $this->command->warn('⚠ Chave privada PIX não encontrada em: ' . $keyPath);
        }

        $this->command->info('✓ Configuração Efí Pay verificada!');
    }
}
