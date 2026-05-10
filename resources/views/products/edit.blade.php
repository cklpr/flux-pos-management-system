@extends('layouts.app')

@section('title', 'Edit Product | SuperCart PoS')

@section('content')
    <div class="max-w-3xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Product</h1>
        <p class="mt-2 text-sm text-slate-500">Update product, stock, and pricing details.</p>

        <form action="{{ route('products.update', $product) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Name</span>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>

                <label class="space-y-2 text-sm text-slate-700">
                    <span>SKU</span>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Category</span>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>

                <label class="space-y-2 text-sm text-slate-700">
                    <span>Barcode</span>
                    <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Cost Price</span>
                    <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>

                <label class="space-y-2 text-sm text-slate-700">
                    <span>Price</span>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>

                <label class="space-y-2 text-sm text-slate-700">
                    <span>Stock Quantity</span>
                    <input type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Reorder Threshold</span>
                    <input type="number" min="0" name="reorder_threshold" value="{{ old('reorder_threshold', $product->reorder_threshold) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
                <div></div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">Update Product</button>
                <a href="{{ route('products.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
