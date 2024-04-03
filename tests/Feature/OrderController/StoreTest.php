<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Str;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

function validOrderPayload($overrides = []): array
{
    $countries = App\Models\Country::factory()
        ->has(App\Models\State::factory())
        ->create();

    $overrides['country_id'] = $countries->first()->id;
    $overrides['state_id']   = $countries->first()->states->first()->id;

    return array_merge([
        'first_name'  => 'John',
        'last_name'   => 'Doe',
        'address'     => '123 Main St',
        'postal_code' => '12345',
        'card_cvv'    => '123',
        'card_expiry' => date('m/y', strtotime('+1 year')),
        'card_number' => '2471 5380 0410 8655',
    ], $overrides);
}

it('requires validation on creating order', function (): void {
    \Pest\Laravel\postJson(route('order.store'))
        ->assertJsonValidationErrorFor('first_name')
        ->assertJsonValidationErrorFor('last_name')
        ->assertJsonValidationErrorFor('address')
        ->assertJsonValidationErrorFor('country_id')
        ->assertJsonValidationErrorFor('state_id')
        ->assertJsonValidationErrorFor('card_cvv')
        ->assertJsonValidationErrorFor('card_expiry')
        ->assertJsonValidationErrorFor('card_number');


    \Pest\Laravel\postJson(route('order.store', [
        'first_name' => 'Bar',
        'last_name'  => 'Foo',
        'address'    => fake()->address(),
    ]))
        ->assertJsonMissingValidationErrors('first_name')
        ->assertJsonMissingValidationErrors('last_name')
        ->assertJsonMissingValidationErrors('address')
        ->assertJsonValidationErrorFor('country_id')
        ->assertJsonValidationErrorFor('state_id')
        ->assertJsonValidationErrorFor('card_cvv')
        ->assertJsonValidationErrorFor('card_expiry')
        ->assertJsonValidationErrorFor('card_number');
});

it('requires a valid body to create order', function ($value): void {
    postJson(route('order.store'), [
        'first_name'  => $value,
        'last_name'   => $value,
        'address'     => $value,
        'country_id'  => $value,
        'state_id'    => $value,
        'postal_code' => $value,
        'card_cvv'    => $value,
        'card_expiry' => $value,
        'card_number' => $value,
    ])
        ->assertInvalid(['first_name', 'last_name', 'address', 'country_id', 'state_id', 'postal_code', 'card_cvv', 'card_expiry', 'card_number']);
})->with([
    null,
    Str::repeat('a', 2501),
]);

test('card number validation fails for invalid card', function (): void {
    postJson(route('order.store'), validOrderPayload(['card_number' => '1111 1111 1111 1111']))
        ->assertStatus(422)
        ->assertJsonValidationErrors('card_number');
});

test('card expiry validation fails for invalid date', function (): void {
    postJson(route('order.store'), validOrderPayload(['card_expiry' => '11/11']))
        ->assertStatus(422)
        ->assertJsonValidationErrors('card_expiry');
});

test('successful order creation', function (): void {
    Product::factory()->count(5)->create();

    getJson(route('cart.show'))->assertOk();

    postJson(route('order.store'), validOrderPayload())
        ->assertStatus(200);
});

test('fails to create order if cart is empty', function (): void {
    getJson(route('cart.show'))->assertOk();

    postJson(route('order.store'), validOrderPayload())
        ->assertStatus(400);
});
