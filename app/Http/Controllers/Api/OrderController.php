<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Daftar produk yang bisa dipesan (sama sumber data dengan dashboard).
     */
    public function products(): JsonResponse
    {
        $products = $this->orderService->getProductsForDashboard();

        return response()->json([
            'data' => $products->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
            ])->values(),
        ]);
    }

    /**
     * Daftar pesanan.
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->listOrders();

        return response()->json([
            'data' => $orders->map(fn ($order) => [
                'id' => $order->id,
                'product_id' => $order->product_id,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'created_at' => $order->created_at?->toIso8601String(),
                'product' => $order->product ? [
                    'id' => $order->product->id,
                    'name' => $order->product->name,
                    'price' => $order->product->price,
                ] : null,
            ])->values(),
        ]);
    }

    /**
     * Buat pesanan baru.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $result = $this->orderService->placeOrder(
            $request->integer('product_id'),
            $request->integer('quantity')
        );

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
            ], 422);
        }

        $order = $result['order'];

        return response()->json([
            'message' => $result['message'],
            'data' => [
                'id' => $order->id,
                'product_id' => $order->product_id,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'created_at' => $order->created_at?->toIso8601String(),
                'product' => $order->product ? [
                    'id' => $order->product->id,
                    'name' => $order->product->name,
                    'price' => $order->product->price,
                ] : null,
            ],
        ], 201);
    }
}
