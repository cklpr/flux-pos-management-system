@extends('layouts.app')

@section('title', 'New Sale | SuperCart PoS')

@section('content')
    <div class="grid gap-8 xl:grid-cols-[1.4fr_0.6fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">New Sale</h1>
                    <p class="mt-1 text-sm text-slate-500">Scan or select products, choose a customer, and complete the checkout.</p>
                </div>
                <a href="{{ route('pos.index') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Go to Dashboard</a>
            </div>

            <form action="{{ route('sales.store') }}" method="POST" id="sale-form" class="mt-8 space-y-6" data-loading>
                @csrf

                <div class="grid gap-6">
                    <label class="space-y-2 text-sm text-slate-700">
                        <span>Customer (optional)</span>
                        <select name="customer_id" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            <option value="">Walk-in customer</option>
                            @foreach (App\Models\Customer::orderBy('name')->get() as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}{{ $customer->phone ? ' • ' . $customer->phone : '' }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="grid gap-4 sm:grid-cols-[1.3fr_0.9fr_0.8fr] items-end" data-index="0">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Product</label>
                            <select id="items-0-product_id" name="items[0][product_id]" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                                <option value="">Choose Product</option>
                                @foreach ($products as $product)
<option value="{{ $product->id }}">{{ $product->name }} — ₱{{ number_format($product->price, 2) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Quantity</label>
                            <input id="items-0-quantity" type="number" name="items[0][quantity]" min="1" value="1" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="button" id="add-item" class="w-full rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">Add Item</button>
                        </div>
                    </div>

                    <div id="cart-items" class="space-y-4"></div>

                    <div class="grid gap-4 sm:grid-cols-[1fr_1fr]">
                        <label class="space-y-2 text-sm text-slate-700">
                            <span>Discount (%)</span>
                            <input type="number" name="discount_percent" min="0" max="100" value="{{ old('discount_percent', 0) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        </label>

                        <label class="space-y-2 text-sm text-slate-700">
                            <span>Payment Method</span>
                            <select name="payment_method" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="mobile" {{ old('payment_method') === 'mobile' ? 'selected' : '' }}>Mobile Payment</option>
                            </select>
                        </label>
                    </div>
                </div>

                <button type="submit" data-submit class="w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Process Sale</button>
            </form>
        </div>

        <aside class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">Checkout Summary</h2>
            <p class="mt-2 text-sm text-slate-500">Build the sale using the available stock and quick checkout fields.</p>

            <div class="mt-6 space-y-4 text-sm text-slate-700">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                    <p class="font-medium">Available Products</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $products->count() }} items available in the catalog.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                    <p class="font-medium">Low stock products</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $lowStockProducts->count() }} products need restocking.</p>
                </div>
            </div>
        </aside>
    </div>

    @php
        $productsJson = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->price, 2, '.', ''),
            ];
        })->toJson();
    @endphp

    <script>
        const products = {!! $productsJson !!};
        const cartItems = document.getElementById('cart-items');
        const addItemButton = document.getElementById('add-item');
        let rowIndex = 1;

        function buildProductOptions() {
            return `<option value="">Choose Product</option>` +
                products.map(product => `<option value="${product.id}">${product.name} — ₱${product.price}</option>`).join('');
        }

        function addCartRow() {
            const row = document.createElement('div');
            row.className = 'grid gap-4 sm:grid-cols-[1.3fr_0.9fr_0.8fr] items-end';
            row.dataset.index = rowIndex;
            row.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-slate-700">Product</label>
                    <select name="items[${rowIndex}][product_id]" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                        ${buildProductOptions()}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Quantity</label>
                    <input type="number" name="items[${rowIndex}][quantity]" min="1" value="1" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" required>
                </div>
                <div class="flex items-end gap-2">
                    <button type="button" data-remove="true" class="w-full rounded-full bg-rose-600 px-4 py-3 text-sm font-semibold text-white hover:bg-rose-700">Remove</button>
                </div>
            `;
            cartItems.appendChild(row);
            rowIndex += 1;
        }

        addItemButton.addEventListener('click', addCartRow);

        cartItems.addEventListener('click', function (event) {
            const removeButton = event.target.closest('[data-remove]');
            if (!removeButton) return;
            const row = removeButton.closest('[data-index]');
            if (row && cartItems.children.length > 0) {
                cartItems.removeChild(row);
            }
        });
    </script>
@endsection
