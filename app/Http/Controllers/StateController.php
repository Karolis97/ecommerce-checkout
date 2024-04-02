<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\JsonResponse;

final class StateController extends Controller
{
    public function __invoke(int $countryId): JsonResponse
    {
        $states = State::where('country_id', $countryId)->get();

        return response()->json(StateResource::collection($states));
    }
}
