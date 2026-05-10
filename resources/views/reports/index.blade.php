@extends('layouts.app')

@section('title', 'Reports | SuperCart PoS')

@section('content')
    <div class="grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h1 class="text-2xl font-semibold text-slate-900">Sales & Inventory Reports</h1>
                <p class="mt-2 text-sm text-slate-500">Review performance, stock status, and customer growth at a glance.</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Revenue Last 30 Days</h2>
                <p class="mt-3 text-4xl font-bold text-emerald-700">{{ \App\Helpers\Currency::format($revenue) }}</p>
                <p class="mt-2 text-sm text-slate-500">Generated from {{ $salesLast30Days->count() }} sales.</p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Top Products</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-700">
                        @foreach ($topProducts as $product)
                            <li class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between gap-2">
                                    <span>{{ $product->name }}</span>
                                    <span class="font-semibold">{{ $product->sold_quantity ?? 0 }} sold</span>
                                </div>
                            </li>
                        @endforeach
                        @if ($topProducts->isEmpty())
                            <li class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-slate-500">No product sales yet.</li>
                        @endif
                    </ul>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Low Stock</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-700">
                        @foreach ($lowStockProducts as $product)
                            <li class="rounded-2xl border border-slate-200 bg-orange-50 p-4">
                                <div class="flex items-center justify-between gap-2">
                                    <span>{{ $product->name }}</span>
                                    <span class="font-semibold">{{ $product->stock_quantity }} left</span>
                                </div>
                            </li>
                        @endforeach
                        @if ($lowStockProducts->isEmpty())
                            <li class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-slate-500">All products are above reorder threshold.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Customer Growth</h2>
                <p class="mt-3 text-4xl font-bold text-slate-900">{{ $customerGrowth }}</p>
                <p class="mt-2 text-sm text-slate-500">New customers in the last 30 days.</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Latest Sales</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-700">
                    @foreach ($salesLast30Days->take(5) as $sale)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <p class="font-medium">Sale #{{ $sale->id }} — {{ \App\Helpers\Currency::format($sale->net_amount) }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $sale->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                    @if ($salesLast30Days->isEmpty())
                        <p class="text-sm text-slate-500">No sales recorded this period.</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
@endsection
