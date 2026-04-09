<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    /**
     * @return Collection<int, Order>
     */
    public function allWithProductLatest(): Collection;

    public function create(array $attributes): Order;
}
