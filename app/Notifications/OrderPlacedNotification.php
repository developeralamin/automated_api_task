<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Placed Successfully')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your order #' . $this->order->id . ' has been placed successfully.')
            ->line('Total Amount: $' . $this->order->total_amount)
            ->line('Current Status: ' . ucfirst($this->order->status))
            ->line('We will notify you once it is confirmed.');
    }
}
