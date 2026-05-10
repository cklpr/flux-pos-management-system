<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_threshold')
            ->orderBy('stock_quantity')
            ->get();

        $today = now();
        $todaySales = Sale::whereDate('created_at', $today)->sum('net_amount');
        $transactionsToday = Sale::whereDate('created_at', $today)->count();
        $totalSales = Sale::sum('net_amount');
        $newCustomers = Customer::whereDate('created_at', $today)->count();

        $grossProfit = Sale::whereDate('created_at', $today)
            ->with('items.product')
            ->get()
            ->flatMap->items
            ->sum(function ($item) {
                $cost = $item->product?->cost_price ?? $item->unit_price;
                return ($item->unit_price - $cost) * $item->quantity;
            });

        $totalProducts = Product::count();
        $inventoryCost = $products->sum(function ($product) {
            return ($product->cost_price ?? $product->price) * $product->stock_quantity;
        });
        $inventoryValue = $products->sum(function ($product) {
            return $product->price * $product->stock_quantity;
        });
        $inventoryPotential = $products->sum(function ($product) {
            return max(0, ($product->price - ($product->cost_price ?? $product->price))) * $product->stock_quantity;
        });

        $recentTransactions = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $weeklySales = collect(range(6, 0))->map(function ($days) use ($today) {
            $date = $today->copy()->subDays($days);
            return [
                'day' => $date->format('D'),
                'amount' => Sale::whereDate('created_at', $date)->sum('net_amount'),
            ];
        });

        return view(
            'dashboard',
            compact(
                'products',
                'lowStockProducts',
                'todaySales',
                'transactionsToday',
                'totalSales',
                'newCustomers',
                'grossProfit',
                'totalProducts',
                'inventoryCost',
                'inventoryValue',
                'inventoryPotential',
                'recentTransactions',
                'weeklySales'
            )
        );
    }
}
