<?php

declare(strict_types=1);


it('returns names of enum cases', function (): void {
    $expected = ['PENDING', 'PROCESSING', 'SHIPPED', 'DELIVERED', 'CANCELED'];
    expect(App\Enums\OrderStatus::names())->toBe($expected);
});

it('returns values of enum cases', function (): void {
    $expected = ['pending', 'processing', 'shipped', 'delivered', 'canceled'];
    expect(App\Enums\OrderStatus::values())->toBe($expected);
});

it('returns an associative array from names to values', function (): void {
    $expected = [
        'PENDING'    => 'pending',
        'PROCESSING' => 'processing',
        'SHIPPED'    => 'shipped',
        'DELIVERED'  => 'delivered',
        'CANCELED'   => 'canceled',
    ];
    expect(App\Enums\OrderStatus::toArray())->toBe($expected);
});

it('returns an associative array from values to values', function (): void {
    $expected = [
        'pending'    => 'pending',
        'processing' => 'processing',
        'shipped'    => 'shipped',
        'delivered'  => 'delivered',
        'canceled'   => 'canceled',
    ];
    expect(App\Enums\OrderStatus::keyByValue())->toBe($expected);
});
