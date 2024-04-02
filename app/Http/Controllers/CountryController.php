<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\JsonResponse;

final class CountryController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(CountryResource::collection(Country::get()));
    }
}
