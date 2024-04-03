<?php

declare(strict_types=1);

use App\Http\Resources\CountryResource;
use App\Models\Country;

it('returns all countries with correct structure', function (): void {
    $countries = Country::factory()->count(3)->create();

    \Pest\Laravel\getJson(route('countries'))
        ->assertOk()
        ->assertJsonStructure(
            [
                '*' => [
                    'value',
                    'label',
                ],
            ],
            CountryResource::collection($countries)
        );
});
