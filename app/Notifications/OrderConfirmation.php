<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;
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
        return (new MailMessage())
            ->line(
                sprintf(
                    '%s %s, your order #%s was created successfully!',
                    $this->order->first_name,
                    $this->order->last_name,
                    $this->order->id
                )
            )
            ->line('Customer details:')
            ->line(
                sprintf(
                    '%s, %s %s %s',
                    $this->order->address,
                    $this->order->country->name,
                    $this->order->state->name,
                    $this->order->postal_code,
                )
            )
            ->line(sprintf('Order status: %s.', $this->order->status->value));
    }
}
