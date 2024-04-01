<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

final class CartService
{
    private Cart $cart;

    public function __construct()
    {
        $this->cart = match (auth()->guest()) {
            true  => Cart::firstOrCreate(['session_id' => session()->getId()]),
            false => auth()->user()->cart ?: auth()->user()->cart()->create(),
        };

        $this->cart->load('items.product');
    }

    public function addItems(Collection $products): self
    {
        $this->cart->items()->createMany(
            $products->map(fn(Product $product) => [
                'product_id' => $product->id,
                'quantity'   => random_int(1, $product->stock_quantity),
            ])->toArray()
        );

        return $this;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function destroyCart()
    {
        return $this->cart->delete();
    }
}
