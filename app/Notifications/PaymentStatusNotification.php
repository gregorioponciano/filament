<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

/**
 * Notificação enviada ao usuário quando o status do pagamento é alterado.
 *
 * Utiliza o canal 'database' do Laravel para armazenar notificações no banco,
 * podendo ser visualizadas tanto no frontend quanto no painel Filament.
 */
class PaymentStatusNotification extends Notification
{
    use Queueable;

    private Payment $payment;
    private string $status;

    /**
     * Mapeamento de status para mensagens em português.
     */
    private const STATUS_MESSAGES = [
        'paid' => 'confirmado',
        'pending' => 'pendente',
        'cancelled' => 'cancelado',
        'refunded' => 'reembolsado',
        'expired' => 'expirado',
    ];

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment, string $status)
    {
        $this->payment = $payment;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusLabel = self::STATUS_MESSAGES[$this->status] ?? $this->status;
        $methodLabel = $this->getPaymentMethodLabel();

        return [
            'payment_id' => $this->payment->id,
            'order_id' => $this->payment->order_id,
            'status' => $this->status,
            'amount' => $this->payment->amount,
            'payment_method' => $this->payment->payment_method,
            'message' => "Pagamento #{$this->payment->id} via {$methodLabel} foi {$statusLabel}.",
            'title' => "Pagamento {$statusLabel}",
            'icon' => $this->getStatusIcon(),
            'color' => $this->getStatusColor(),
            'url' => $this->payment->order_id
                ? route('produtos.orders', $this->payment->order_id)
                : null,
        ];
    }

    /**
     * Retorna o rótulo do método de pagamento em português.
     */
    private function getPaymentMethodLabel(): string
    {
        return match ($this->payment->payment_method) {
            'pix' => 'PIX',
            'credit_card' => 'Cartão de Crédito',
            'boleto' => 'Boleto Bancário',
            default => $this->payment->payment_method,
        };
    }

    /**
     * Retorna o ícone baseado no status.
     */
    private function getStatusIcon(): string
    {
        return match ($this->status) {
            'paid' => 'heroicon-o-check-circle',
            'pending' => 'heroicon-o-clock',
            'cancelled', 'expired' => 'heroicon-o-x-circle',
            'refunded' => 'heroiconO-arrow-path',
            default => 'heroicon-o-information-circle',
        };
    }

    /**
     * Retorna a cor baseada no status.
     */
    private function getStatusColor(): string
    {
        return match ($this->status) {
            'paid' => 'success',
            'pending' => 'warning',
            'cancelled', 'expired' => 'danger',
            'refunded' => 'info',
            default => 'gray',
        };
    }
}
