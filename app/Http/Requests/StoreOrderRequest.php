<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
                'required',
                Rule::exists('states', 'id')->where(fn($query) => $query->where('country_id', $this->country_id)),
            ],
            'postal_code' => 'required|string|max:255',
            //            'card_cvv'    => 'required|numeric|digits_between:3,4',
            //            'card_expiry' => [
            //                'required',
            //                'date_format:m/y',
            //                'after_or_equal:' . date('m/y')
            //            ],
            //            'card_number' => [
            //                'required',
            //                'string',
            //                'regex:/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/', // Validates the format 1111 2222 3333 4444
            //                function ($attribute, $value, $fail): void {
            //                    // Removing spaces for the Luhn check
            //                    $number = str_replace(' ', '', $value);
            //                    if ( ! preg_match('/^\d+$/', $number) || ! $this->luhn_check($number)) {
            //                        $fail($attribute . ' is invalid.');
            //                    }
            //                },
            //            ],
        ];
    }

    private function luhn_check($number): bool
    {
        $len      = mb_strlen($number);
        $sum      = 0;
        $isSecond = false;
        for ($i = $len - 1; $i >= 0; $i--) {
            $d = $number[$i];

            if ($isSecond) {
                $d *= 2;
            }

            $sum += floor($d / 10);
            $sum += $d % 10;

            $isSecond = ! $isSecond;
        }
        return (0 === $sum % 10);
    }
}
