<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $salesLast30Days = Sale::where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderByDesc('created_at')
            ->get();

        $topProducts = Product::orderByDesc('sold_quantity')
            ->limit(8)
            ->get();

        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_threshold')
            ->orderBy('stock_quantity')
            ->get();

        $customerGrowth = Customer::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $revenue = $salesLast30Days->sum('net_amount');

        return view('reports.index', compact('salesLast30Days', 'topProducts', 'lowStockProducts', 'customerGrowth', 'revenue'));
    }
}
