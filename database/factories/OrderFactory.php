<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
final class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status'      => fake()->randomElement(array_column(OrderStatus::cases(), 'value')),
            'first_name'  => fake()->firstName(),
            'last_name'   => fake()->lastName(),
            'address'     => fake()->address(),
            'postal_code' => fake()->postcode(),
        ];
    }

    public function withCountry(): OrderFactory
    {
        $countries = Country::has('states')->get();

        return $this->state(function () use ($countries) {
            $country = $countries->random();
            $state   = $country->states->random();

            return [
                'country_id' => $country->id,
                'state_id'   => $state->id,
            ];
        });
    }
}
