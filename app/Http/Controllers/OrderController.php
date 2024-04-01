<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;

final class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, CartService $cartService, OrderService $orderService): JsonResponse
    {
        try {
            $cart = $cartService->getCart();

            if ($cart->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The cart is empty. Add some products before creating an order.'
                ], 400);
            }

            $order = $orderService->createOrder($request->validated(), $cart);
            $cartService->destroyCart();

            return response()->json(['success' => true, 'data' => ['order_id' => $order->id]]);
        } catch (Exception $exception) {
            info('Failed to create order', [
                'user_id' => auth()->user()?->getAuthIdentifier(),
                'message' => $exception->getMessage(),
                'code'    => $exception->getCode(),
            ]);

            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
