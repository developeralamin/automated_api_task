<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Order has been Confirmed ')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your order #' . $this->order->id . ' has been confirmed.')
            ->line('Total Amount: $' . $this->order->total_amount)
            ->line('Status: ' . ucfirst($this->order->status))
            ->line('Thank you for shopping with us!');
    }
}
