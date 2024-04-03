<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get();

        User::factory(20)
            ->has(
                Order::factory(3)
                    ->has(
                        OrderItem::factory(3)->state(function () use ($products) {
                            $product  = $products->random();
                            $quantity = random_int(1, min($product->stock_quantity, 3));
                            $price    = $quantity * $product->price;
                            $product->decrement('stock_quantity', $quantity);

                            return [
                                'product_id' => $product->id,
                                'quantity'   => $quantity,
                                'price'      => $price,
                            ];
                        }),
                        'items',
                    )
                    ->withCountry()
            )
            ->has(
                Cart::factory()
                    ->has(
                        CartItem::factory(3)->state(function () use ($products) {
                            $product  = $products->random();
                            $quantity = random_int(1, min($product->stock_quantity, 3));

                            return [
                                'product_id' => $product->id,
                                'quantity'   => $quantity,
                            ];
                        }),
                        'items',
                    )
            )
            ->create();
    }

    private function createOrderItems(User $user): void {}
}
