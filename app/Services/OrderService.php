<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private OrderRepositoryInterface $orderRepository,
    ) {}

    /**
     * @return Collection<int, Product>
     */
    public function getProductsForDashboard(): Collection
    {
        return $this->productRepository->all();
    }

    /**
     * @return Collection<int, Order>
     */
    public function listOrders(): Collection
    {
        return $this->orderRepository->allWithProductLatest();
    }

    /**
     * @return array{success: bool, message: string, order?: Order}
     */
    public function placeOrder(?int $productId, int $quantity): array
    {
        $product = $this->productRepository->find((int) ($productId ?? 0));

        if (!$product) {
            return ['success' => false, 'message' => 'Produk tidak ditemukan.'];
        }

        if ($quantity <= 0) {
            return ['success' => false, 'message' => 'Jumlah harus lebih dari 0.'];
        }

        if ($product->stock < $quantity) {
            return ['success' => false, 'message' => 'Stok tidak mencukupi.'];
        }

        $totalPrice = $product->price * $quantity;

        $this->productRepository->decrementStock($product, $quantity);

        $order = $this->orderRepository->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return [
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'order' => $order,
        ];
    }
}
