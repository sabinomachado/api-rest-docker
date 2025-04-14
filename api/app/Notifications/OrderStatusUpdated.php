<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'new_status' => $this->order->status,
        ];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage())
            ->subject('Status da ordem atualizado')
            ->line('O status da ordem #' . $this->order->id . ' foi alterado para: ' . $this->order->status)
            ->action('Ver pedido', url('/orders/' . $this->order->id));
    }
}
