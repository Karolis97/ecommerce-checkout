<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

final class OrderService
{
    public function createOrder(array $data, Cart $cart): Order
    {
        return DB::transaction(function () use ($data, $cart): Order {
            $order = Order::create([
                'user_id' => auth()->user()?->getAuthIdentifier(),
                'status'  => OrderStatus::PENDING,
                ...$data,
            ]);

            $order->items()->createMany($cart->items->map(fn($item) => [
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price * $item->quantity,
            ])->toArray());

            return $order;
        });
    }
}
