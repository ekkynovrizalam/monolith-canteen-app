<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Display the dashboard with products.
     */
    public function index(): View
    {
        $products = $this->orderService->getProductsForDashboard();

        return view('dashboard', compact('products'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request): RedirectResponse
    {
        $result = $this->orderService->placeOrder(
            $request->integer('product_id'),
            $request->integer('quantity')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }
}
