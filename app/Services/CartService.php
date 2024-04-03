<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    private Cart $cart;

    public function __construct()
    {
        $this->cart = match (auth()->guest()) {
            true  => Cart::firstOrCreate(['session_id' => session()->getId()]),
            false => auth()->user()->cart ?: auth()->user()->cart()->create(),
        };

        // TODO: Implement add to cart logic
        if ($this->cart->items->isEmpty()) {
            $products = Product::inRandomOrder()->limit(2)->get(['id', 'price', 'stock_quantity']);
            $this->addItems($products);
        }
    }

    public function addItems(Collection $products): Cart
    {
        $this->cart->items()->createMany(
            $products->map(fn(Product $product) => [
                'product_id' => $product->id,
                'quantity'   => random_int(1, $product->stock_quantity),
            ])->toArray()
        );

        info('Adding products to cart', ['product_ids' => $products->pluck('id')->toArray()]);
        info('Cart items', ['items' => $this->cart->items()->get()]);
        info('Cart id and session id', ['cart_id' => $this->cart->id, 'session_id' => $this->cart->session_id]);
        return $this->cart;
    }

    public function removeItem(int $productId): self
    {
        info($this->cart->id);
        $this->cart->items()->where('product_id', $productId)->delete();

        return $this;
    }

    public function getCart(): Cart
    {
        $this->cart->load('items.product');

        return $this->cart;
    }

    public function destroyCart()
    {
        return $this->cart->delete();
    }
}
