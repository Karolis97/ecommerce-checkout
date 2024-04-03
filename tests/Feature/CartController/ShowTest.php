<?php

declare(strict_types=1);


use App\Models\Cart;
use App\Models\Product;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('stores cart', function (): void {
    getJson(route('cart.show'))->assertOk();

    $this->assertDatabaseHas(Cart::class, [
        'session_id' => session()->getId()
    ]);
});

it('display cart', function (): void {
    \Pest\Laravel\getJson(route('cart.show'))
        ->assertOk()
        ->assertJsonStructure(
            [
                'items' => [
                    '*' => [
                        'quantity',
                        'product' => [
                            '*' => [
                                'id',
                                'name',
                                'description',
                                'price',
                            ],
                        ],
                        'total_price',
                    ],
                ],
                'total_price',
            ],
        );
});

it('updates the cart with random products', function (): void {
    Product::factory()->count(5)->create();

    postJson(route('cart.update'))
        ->assertOk()
        ->assertJson(['success' => true]);

    $cart    = Cart::with('items.product')->first();
    $product = $cart->items->random()->product;

    $this->assertDatabaseHas('cart_items', [
        'cart_id'    => $cart->id,
        'product_id' => $product->id,
    ]);
});

it('deletes a random product from the cart', function (): void {
    $sessionId = session()->getId();

    Product::factory()->count(5)->create();

    \Pest\Laravel\getJson(route('cart.show'))->assertOk();

    $cart            = Cart::with('items.product')->where('session_id', $sessionId)->firstOrFail();
    $productToDelete = $cart->items->first()->product;

    \Pest\Laravel\deleteJson(route('cart.delete-product', ['productId' => $productToDelete->id]))
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Product removed successfully',
        ]);

    $this->assertDatabaseMissing('cart_items', [
        'cart_id'    => $cart->id,
        'product_id' => $productToDelete->id,
    ]);
});
