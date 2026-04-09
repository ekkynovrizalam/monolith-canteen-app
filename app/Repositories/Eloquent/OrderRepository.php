<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function allWithProductLatest(): Collection
    {
        return Order::query()
            ->with('product')
            ->latest()
            ->get();
    }

    public function create(array $attributes): Order
    {
        return Order::query()
            ->create($attributes)
            ->load('product');
    }
}
