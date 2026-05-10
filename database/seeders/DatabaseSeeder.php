<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fluxpos.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        Customer::create([
            'name' => 'Walk-in Customer',
            'email' => null,
            'phone' => null,
        ]);

        Product::create([ 'name' => 'Organic Coffee Beans', 'sku' => 'COFFEE-001', 'description' => 'Fresh roasted coffee, 1kg bag.', 'price' => 12.50, 'cost_price' => 6.50, 'stock_quantity' => 18, 'category' => 'Beverages', 'reorder_threshold' => 5 ]);
        Product::create([ 'name' => 'Wireless Barcode Scanner', 'sku' => 'SCANNER-001', 'description' => 'Lightweight scanner for fast checkout.', 'price' => 89.99, 'cost_price' => 65.00, 'stock_quantity' => 7, 'category' => 'Hardware', 'reorder_threshold' => 3 ]);
        Product::create([ 'name' => 'Classic Cash Register', 'sku' => 'REGISTER-001', 'description' => 'Durable register with receipt printer.', 'price' => 159.00, 'cost_price' => 110.00, 'stock_quantity' => 4, 'category' => 'Hardware', 'reorder_threshold' => 5 ]);
        Product::create([ 'name' => 'Receipt Paper Roll', 'sku' => 'PAPER-001', 'description' => 'High-quality thermal paper.', 'price' => 3.75, 'cost_price' => 1.20, 'stock_quantity' => 120, 'category' => 'Supplies', 'reorder_threshold' => 20 ]);
        Product::create([ 'name' => 'POS Terminal License', 'sku' => 'LICENSE-001', 'description' => 'Annual subscription for point of sale access.', 'price' => 299.00, 'cost_price' => 120.00, 'stock_quantity' => 999, 'category' => 'Services', 'reorder_threshold' => 50 ]);
    }
}
