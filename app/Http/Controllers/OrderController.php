<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display the dashboard with products.
     */
    public function index(): View
    {
        $products = Product::all();

        return view('dashboard', compact('products'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request): RedirectResponse
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $quantity = (int) $request->quantity;

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0.');
        }

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $totalPrice = $product->price * $quantity;

        $product->decrement('stock', $quantity);

        Order::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat.');
    }
}
