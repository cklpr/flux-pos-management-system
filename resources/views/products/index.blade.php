@extends('layouts.app')

@section('title', 'Products | SuperCart PoS')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Products</h1>
                <p class="mt-1 text-sm text-slate-500">Manage inventory, pricing, restock thresholds, and SKU details.</p>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">Add Product</a>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Reorder</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($products as $product)
                        <tr class="@if($product->stock_quantity <= $product->reorder_threshold) bg-rose-50 @endif">
                            <td class="px-4 py-4 font-medium @if($product->stock_quantity <= $product->reorder_threshold) text-rose-900 @else text-slate-900 @endif">{{ $product->name }} @if($product->stock_quantity <= $product->reorder_threshold)<span class="text-xs text-rose-600 ml-2">⚠️ Low Stock</span>@endif</td>
                            <td class="px-4 py-4">{{ $product->sku }}</td>
                            <td class="px-4 py-4">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-4 @if($product->stock_quantity <= $product->reorder_threshold) font-semibold text-rose-600 @endif">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-4">{{ $product->reorder_threshold }}</td>
                            <td class="px-4 py-4 space-x-2">
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-700">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Remove this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">No products found. Add your first item to get started.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection
