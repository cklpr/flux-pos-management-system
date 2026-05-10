@extends('layouts.app')

@section('title', 'Sales | SuperCart PoS')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Sales History</h1>
                <p class="mt-1 text-sm text-slate-500">Browse completed sales, invoices, payment methods, and customer activity.</p>
            </div>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">New Sale</a>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-4 py-3">Invoice</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Net</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $sale->invoice_number ?? 'INV-' . $sale->id }}</td>
                            <td class="px-4 py-4">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                            <td class="px-4 py-4">{{ \App\Helpers\Currency::format($sale->total_amount) }}</td>
                            <td class="px-4 py-4">{{ \App\Helpers\Currency::format($sale->net_amount) }}</td>
                            <td class="px-4 py-4 capitalize">{{ $sale->payment_method }}</td>
                            <td class="px-4 py-4">{{ $sale->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-4">
                                <a href="{{ route('sales.show', $sale) }}" class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-700">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No sales have been recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $sales->links() }}</div>
    </div>
@endsection
