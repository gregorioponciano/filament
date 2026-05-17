🚀 Para Subir em Produção
Antes de fazer deploy para www.gpwebsolution.com:
1. Configurar Webhook Token:
      openssl rand -hex 32
      Colocar o resultado em EFIPAY_WEBHOOK_TOKEN no .env
2. Configurar Payee Code (Cartão):
   - Obter no painel Efí Pay → Configurações → Identificador de Conta
   - Colocar em EFIPAY_PAYEE_CODE no .env
3. Certificado PIX:
   - Colocar o certificado .pem em storage/app/certs/
   - Verificar se EFIPAY_CERT_PATH e EFIPAY_CHAVE_PATH estão corretos
4. Configurar Webhook no Efí Pay:
   - URL: https://www.gpwebsolution.com/api/webhook/efipay
   - Verificar endpoint: https://www.gpwebsolution.com/api/webhook/efipay/verify
5. Permissões Linux:
      chmod -R 775 storage bootstrap/cache
   chmod -R 775 public/build
   
6. Rodar migrate:
      php artisan migrate --force
   
7. Build assets:
      npm run build
   
8. Otimizações Laravel:
      php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link
   
9. Verificar .env final — manter APP_DEBUG=false e APP_ENV=production