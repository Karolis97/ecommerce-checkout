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
    private CartService $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function show(): JsonResponse
    {
        if ($this->cartService->getCart()->items->isEmpty()) {
            $this->update();
        }

        return response()->json(CartResource::make($this->cartService->getCart()));
    }

    public function update(): JsonResponse
    {
        try {
            $products = Product::inRandomOrder()->limit(2)->get(['id', 'price', 'stock_quantity']);
            $this->cartService->addItems($products);

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

    public function deleteProduct(int $productId): JsonResponse
    {
        $this->cartService->removeItem($productId);

        return response()->json(['success' => true, 'message' => 'Product removed successfully']);
    }
}
