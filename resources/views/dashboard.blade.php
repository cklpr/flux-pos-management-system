@extends('layouts.app')

@section('title', 'Dashboard | FLUX PoS')

@section('content')
    @php
        $trendStart = $weeklySales->first()['amount'] ?? 0;
        $trendEnd = $weeklySales->last()['amount'] ?? 0;
        $trendPercent = $trendStart > 0 ? round((($trendEnd - $trendStart) / $trendStart) * 100) : 0;
        $trendLabel = ($trendPercent >= 0 ? '+' : '') . $trendPercent . '% Last 7 days';
        $chartMax = max($weeklySales->pluck('amount')->max(), 1);
        $chartPoints = $weeklySales->map(function ($item, $index) use ($chartMax) {
            $x = 40 + ($index * 96);
            $y = 170 - ($item['amount'] / $chartMax) * 120;
            return "{$x},{$y}";
        })->implode(' ');
        $totalWeekly = $weeklySales->sum('amount');
        $performanceLabel = $trendPercent >= 0 ? 'up' : 'down';
    @endphp

    <div class="max-w-[1800px] mx-auto px-8 py-6 space-y-6">
        <header class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-6 shadow-[0_24px_80px_-40px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-cyan-500/20">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                <div class="space-y-3">
                    <p class="text-sm uppercase tracking-[0.35em] text-cyan-400/80">Welcome, Admin</p>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:gap-6">
                        <h1 class="text-3xl font-semibold text-white">Store performance overview</h1>
                    </div>
                    <p class="max-w-2xl text-sm leading-6 text-slate-400">Here is your store performance for today. Monitor revenue, transactions, inventory, and activity from one advanced dashboard.</p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:-translate-y-0.5 hover:bg-cyan-400">Start sale</a>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-5">
            <article class="rounded-[28px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Today revenue</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-target="{{ $todaySales }}">{{ \App\Helpers\Currency::format($todaySales) }}</p>
                <p class="mt-3 text-sm text-slate-400">Net sales for today.</p>
            </article>
            <article class="rounded-[28px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Transactions today</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-target="{{ $transactionsToday }}">0</p>
                <p class="mt-3 text-sm text-slate-400">Processed orders today.</p>
            </article>
            <article class="rounded-[28px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Gross profit</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-target="{{ $grossProfit }}">{{ \App\Helpers\Currency::format($grossProfit) }}</p>
                <p class="mt-3 text-sm text-slate-400">Estimated profit for today.</p>
            </article>
            <article class="rounded-[28px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Low stock</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-target="{{ $lowStockProducts->count() }}">0</p>
                <p class="mt-3 text-sm text-slate-400">Items below reorder threshold.</p>
            </article>
            <article class="rounded-[28px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Total products</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-target="{{ $totalProducts }}">0</p>
                <p class="mt-3 text-sm text-slate-400">Active SKUs in the catalog.</p>
            </article>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 space-y-6">
                <section class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Sales trend</h2>
                            <p class="mt-2 text-sm text-slate-400">7-day revenue performance.</p>
                        </div>
                        <div class="rounded-full bg-slate-900/90 px-3 py-1 text-sm font-semibold text-slate-300">{{ $trendLabel }}</div>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-3xl font-semibold text-white">{{ \App\Helpers\Currency::format($totalWeekly) }}</p>
                            <p class="mt-2 text-sm text-slate-400">Total sales for the last 7 days.</p>
                        </div>
                        <div class="rounded-[24px] border border-slate-800/70 bg-slate-900/80 p-4 text-sm text-slate-300">
                            <p class="font-semibold text-white">Performance</p>
                            <p class="mt-2 text-sm text-slate-400">Revenue is {{ $performanceLabel }} since the week began.</p>
                        </div>
                    </div>

                    <div class="mt-5 overflow-hidden rounded-[24px] bg-slate-900/80 p-4">
                        <svg viewBox="0 0 700 220" class="w-full" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="salesGradient" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.45" />
                                    <stop offset="100%" stop-color="#22d3ee" stop-opacity="0.03" />
                                </linearGradient>
                            </defs>
                            <path d="M40 190 L40 40 L{{ $chartPoints }} L{{ 40 + (($weeklySales->count() - 1) * 96) }} 190 Z" fill="url(#salesGradient)" opacity="0.9" />
                            <polyline fill="none" stroke="#22d3ee" stroke-width="4" points="{{ $chartPoints }}" stroke-linecap="round" stroke-linejoin="round" />
                            @foreach($weeklySales as $index => $item)
                                @php
                                    $x = 40 + ($index * 96);
                                    $y = 170 - ($item['amount'] / $chartMax) * 120;
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#22d3ee" />
                            @endforeach
                        </svg>
                        <div class="mt-4 grid grid-cols-7 gap-2 text-center text-[11px] uppercase tracking-[0.2em] text-slate-500">
                            @foreach($weeklySales as $item)
                                <div>{{ $item['day'] }}</div>
                            @endforeach
                        </div>
                    </div>
                </section>


                <section class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Recent transactions</h2>
                            <p class="text-sm text-slate-400">Latest completed sales.</p>
                        </div>
                        <span class="rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-slate-400">5 most recent</span>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentTransactions as $sale)
                            <div class="flex flex-col gap-2 rounded-[24px] border border-slate-800/70 bg-slate-900/80 p-3 text-sm transition hover:border-cyan-500/40 hover:bg-slate-900">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-semibold text-white">{{ $sale->invoice_number ?? 'INV-' . $sale->id }}</p>
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $sale->created_at->format('H:i') }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-3 text-slate-400">
                                    <p>{{ $sale->customer->name ?? 'Walk-in' }}</p>
                                    <p class="font-semibold text-white">{{ \App\Helpers\Currency::format($sale->net_amount) }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No completed transactions yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <section class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Inventory snapshot</h2>
                            <p class="text-sm text-slate-400">Top 5 products by stock.</p>
                        </div>
                        <span class="rounded-full bg-slate-900 px-2 py-0.5 text-xs font-semibold uppercase text-slate-400">Top</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($products->take(5) as $product)
                            @php
                                $stockLevel = $product->stock_quantity <= $product->reorder_threshold ? 'low' : ($product->stock_quantity <= ($product->reorder_threshold * 2) ? 'moderate' : 'healthy');
                                $statusClass = $stockLevel === 'low' ? 'bg-rose-500/10 text-rose-200' : ($stockLevel === 'moderate' ? 'bg-amber-500/10 text-amber-200' : 'bg-emerald-500/10 text-emerald-200');
                                $statusLabel = $stockLevel === 'low' ? 'Low' : ($stockLevel === 'moderate' ? 'Moderate' : 'Healthy');
                            @endphp
                            <div class="flex items-center justify-between gap-3 rounded-[24px] border border-slate-800/70 bg-slate-900/80 p-3">
                                <div>
                                    <p class="font-semibold text-white text-sm">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-400">{{ \App\Helpers\Currency::format($product->price) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-white">{{ $product->stock_quantity }}</p>
                                    <span class="mt-1 inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase {{ $statusClass }}">{{ $statusLabel }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Low stock alerts</h2>
                            <p class="text-sm text-slate-400">Urgent reorder items.</p>
                        </div>
                        <span class="rounded-full bg-rose-600 px-2 py-0.5 text-xs font-semibold text-rose-100">{{ $lowStockProducts->count() }}</span>
                    </div>
                    <div class="space-y-3">
                        @forelse ($lowStockProducts->take(5) as $product)
                            <div class="rounded-[24px] border border-rose-500/40 bg-rose-950/80 p-3 text-sm text-slate-200 transition hover:bg-rose-950/90">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <span class="text-xs text-rose-300">Reorder {{ $product->reorder_threshold }}</span>
                                </div>
                                <p class="mt-1 text-xs text-slate-400">Only {{ $product->stock_quantity }} left</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">All stock levels are healthy.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-[32px] border border-slate-800/70 bg-slate-950/90 p-5 shadow-[0_18px_40px_-24px_rgba(15,23,42,0.85)] transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/20">
                    <h2 class="text-lg font-semibold text-white mb-4">Inventory value</h2>
                    <div class="space-y-3 text-sm text-slate-300">
                        <div class="flex items-center justify-between gap-3 rounded-[24px] border border-slate-800/70 bg-slate-900/80 px-4 py-3">
                            <span>Retail value</span>
                            <span class="font-semibold text-white">{{ \App\Helpers\Currency::format($inventoryValue) }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-3 rounded-[24px] border border-slate-800/70 bg-slate-900/80 px-4 py-3">
                            <span>Cost basis</span>
                            <span class="font-semibold text-slate-300">{{ \App\Helpers\Currency::format($inventoryCost) }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-3 rounded-[24px] border border-slate-800/70 bg-slate-900/80 px-4 py-3">
                            <span>Profit potential</span>
                            <span class="font-semibold text-emerald-300">{{ \App\Helpers\Currency::format($inventoryPotential) }}</span>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-target]').forEach(function (element) {
                const target = Number(element.getAttribute('data-target')) || 0;
                let current = 0;
                const step = Math.max(Math.round(target / 20), 1);
                const prefix = element.textContent.trim().startsWith('₱') ? '₱' : '';
                const formatter = target % 1 === 0 ? function (value) { return value.toLocaleString('en-US'); } : function (value) { return value.toFixed(2); };
                const update = function () {
                    current += step;
                    if (current >= target) {
                        element.textContent = prefix + formatter(target);
                        return;
                    }
                    element.textContent = prefix + formatter(current);
                    requestAnimationFrame(update);
                };
                if (target > 0) {
                    element.textContent = prefix + '0';
                    requestAnimationFrame(update);
                }
            });
        });
    </script>
@endsection
