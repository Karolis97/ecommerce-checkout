<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Services\CartService;
use Exception;
use Illuminate\Http\JsonResponse;

final class CartController extends Controller
{
    public function show(CartService $cartService): JsonResponse
    {
        return response()->json(CartResource::make($cartService->getCart()));
    }

    public function update(CartService $cartService): JsonResponse
    {
        try {
            $products = Product::inRandomOrder()->limit(2)->get(['id', 'price', 'stock_quantity']);
            $cartService->addItems($products);

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            info('Failed to add products to cart', [
                'user_id' => auth()->user()?->getAuthIdentifier(),
                'message' => $exception->getMessage(),
                'code'    => $exception->getCode(),
            ]);

            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
