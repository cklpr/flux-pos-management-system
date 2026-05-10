@extends('layouts.app')

@section('title', 'Sale Receipt | FLUX PoS')

@section('content')
    <div class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Sale Receipt</h1>
                <p class="mt-1 text-sm text-slate-500">Invoice {{ $sale->invoice_number ?? 'INV-' . $sale->id }}</p>
            </div>
            <div class="space-y-1 text-right text-sm text-slate-600">
                <p><strong>Date:</strong> {{ $sale->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Payment:</strong> {{ ucfirst($sale->payment_method) }}</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.9fr]">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm font-semibold text-slate-700">Customer</p>
                <p class="mt-3 text-base text-slate-900">{{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
                @if ($sale->customer)
                    <p class="mt-1 text-sm text-slate-500">{{ $sale->customer->phone ?? $sale->customer->email }}</p>
                @endif
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm font-semibold text-slate-700">Cashier</p>
                <p class="mt-3 text-base text-slate-900">{{ $sale->cashier->name ?? 'System' }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ ucfirst($sale->status) }}</p>
            </div>
        </div>

        <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Unit Price</th>
                        <th class="px-4 py-3">Quantity</th>
                        <th class="px-4 py-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($sale->items as $item)
                        <tr>
                            <td class="px-4 py-4">{{ $item->product->name }}</td>
                            <td class="px-4 py-4">{{ \App\Helpers\Currency::format($item->unit_price) }}</td>
                            <td class="px-4 py-4">{{ $item->quantity }}</td>
                            <td class="px-4 py-4">{{ \App\Helpers\Currency::format($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm text-slate-500">Total amount</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ \App\Helpers\Currency::format($sale->total_amount) }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm text-slate-500">Net amount after discount</p>
                <p class="mt-2 text-xl font-semibold text-emerald-700">{{ \App\Helpers\Currency::format($sale->net_amount) }}</p>
                <p class="mt-1 text-sm text-slate-500">Discount: {{ \App\Helpers\Currency::format($sale->discount_amount) }}</p>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('sales.index') }}" class="inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700">Back to Sales</a>
            <a href="{{ route('pos.index') }}" class="inline-flex rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
        </div>
    </div>
@endsection
