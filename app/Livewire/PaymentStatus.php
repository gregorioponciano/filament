<?php

namespace App\Livewire;

use App\Models\Payment;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para exibir e atualizar o status do pagamento em tempo real.
 *
 * Exibe o status do pagamento na página de checkout e notifica o usuário
 * quando o status muda (webhook processado).
 */
class PaymentStatus extends Component
{
    public Payment $payment;

    public string $status;
    public string $paymentMethod;
    public ?string $qrCode = null;
    public ?string $qrCodeUrl = null;
    public ?string $boletoUrl = null;
    public ?string $boletoBarcode = null;
    public ?float $amount = null;

    public int $pollingInterval = 10;

    protected $rules = [];

    public function mount(Payment $payment): void
    {
        if ($payment->user_id !== Auth::id() && !Auth::user()?->isAdmin()) {
            abort(403);
        }

        $this->payment = $payment;
        $this->status = $payment->status;
        $this->paymentMethod = $payment->payment_method;
        $this->qrCode = $payment->pix_qr_code;
        $this->qrCodeUrl = $payment->pix_qr_code_url;
        $this->boletoUrl = $payment->boleto_url;
        $this->boletoBarcode = $payment->boleto_barcode;
        $this->amount = $payment->amount;
    }

    protected function getEventListeners(): array
    {
        return [
            'paymentStatusUpdated' => 'refreshStatus',
        ];
    }

    public function render()
    {
        return view('livewire.payment-status');
    }

    public function refreshStatus(): void
    {
        $this->payment->refresh();

        $oldStatus = $this->status;
        $newStatus = $this->payment->status;

        $this->status = $newStatus;
        $this->qrCode = $this->payment->pix_qr_code;
        $this->qrCodeUrl = $this->payment->pix_qr_code_url;
        $this->boletoUrl = $this->payment->boleto_url;
        $this->boletoBarcode = $this->payment->boleto_barcode;

        if ($oldStatus !== $newStatus) {
            $this->notifyStatusChange();

            if (in_array($newStatus, ['paid', 'cancelled', 'refunded', 'expired'])) {
                $this->dispatch('paymentFinalized', status: $newStatus);
            }
        }
    }

    public function checkStatus(): void
    {
        $this->refreshStatus();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'paid' => 'Pago',
            'pending' => 'Pendente',
            'cancelled' => 'Cancelado',
            'refunded' => 'Reembolsado',
            'expired' => 'Expirado',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColor(): string
    {
        return match ($this->status) {
            'paid' => 'text-green-600',
            'pending' => 'text-yellow-600',
            'cancelled', 'expired' => 'text-red-600',
            'refunded' => 'text-blue-600',
            default => 'text-gray-600',
        };
    }

    private function notifyStatusChange(): void
    {
        $statusLabel = $this->getStatusLabel();

        if ($this->status === 'paid') {
            Notification::make()
                ->title('Pagamento Confirmado!')
                ->body("Seu pagamento via {$this->getMethodLabel()} foi confirmado.")
                ->success()
                ->send();
        } elseif ($this->status === 'cancelled' || $this->status === 'expired') {
            Notification::make()
                ->title('Pagamento ' . $statusLabel)
                ->body("Seu pagamento via {$this->getMethodLabel()} foi {$statusLabel}.")
                ->danger()
                ->send();
        } else {
            Notification::make()
                ->title('Status do Pagamento')
                ->body("Seu pagamento via {$this->getMethodLabel()} está {$statusLabel}.")
                ->warning()
                ->send();
        }
    }

    private function getMethodLabel(): string
    {
        return match ($this->paymentMethod) {
            'pix' => 'PIX',
            'credit_card' => 'Cartão de Crédito',
            'boleto' => 'Boleto',
            default => $this->paymentMethod,
        };
    }
}
