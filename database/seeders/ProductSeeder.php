<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Nasi Goreng', 'price' => 15000, 'stock' => 50],
            ['name' => 'Mie Goreng', 'price' => 12000, 'stock' => 40],
            ['name' => 'Es Teh', 'price' => 3000, 'stock' => 100],
            ['name' => 'Es Jeruk', 'price' => 5000, 'stock' => 80],
            ['name' => 'Ayam Goreng', 'price' => 18000, 'stock' => 30],
            ['name' => 'Soto Ayam', 'price' => 14000, 'stock' => 25],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
