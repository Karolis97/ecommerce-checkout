<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Notifications\OrderConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderConfirmation implements ShouldQueue
{
    public int $delay = 60 * 5;

    public function __construct() {}

    public function handle(OrderCreated $event): void
    {
        $this->sendNotification($event->getOrder());
    }

    private function sendNotification(Order $order): void
    {
        Notification::route('mail', [
            config('mail.receiver.address') => config('mail.receiver.name'),
        ])->notify(new OrderConfirmation($order));
    }
}
