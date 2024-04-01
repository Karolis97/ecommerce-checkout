<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

final class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'state_id'   => [
                'nullable',
                Rule::exists('states', 'id')->where(fn($query) => $query->where('country_id', $this->country_id)),
            ],
            'postal_code' => 'required|string|max:255',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'false',
            'message' => 'Validation errors',
            'data'    => $validator->errors(),
        ]));
    }
}
