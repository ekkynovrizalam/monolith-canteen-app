<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * @return Collection<int, Product>
     */
    public function getProductsForDashboard(): Collection
    {
        return Product::all();
    }

    /**
     * @return array{success: bool, message: string}
     */
    public function placeOrder(?int $productId, int $quantity): array
    {
        $product = Product::find($productId);

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

        $product->decrement('stock', $quantity);

        Order::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return ['success' => true, 'message' => 'Pesanan berhasil dibuat.'];
    }
}
