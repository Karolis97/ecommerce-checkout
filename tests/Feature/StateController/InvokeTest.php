<?php

declare(strict_types=1);

use App\Models\Country;

it('returns all states by country with correct structure', function (): void {
    $countries = Country::factory()
        ->has(App\Models\State::factory(5))
        ->count(3)
        ->create();

    \Pest\Laravel\getJson(route('states', $countries->random()->id))
        ->assertOk()
        ->assertJsonStructure(
            [
                '*' => [
                    'value',
                    'label',
                ],
            ],
            App\Http\Resources\StateResource::collection(App\Models\State::get())
        );
});
