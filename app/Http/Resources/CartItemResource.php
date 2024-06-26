<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quantity'    => $this->quantity,
            'product'     => $this->whenLoaded('product', fn() => ProductResource::make($this->product)),
            'total_price' => $this->product->getPriceByQuantity($this->quantity),
        ];
    }
}
