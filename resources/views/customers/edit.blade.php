@extends('layouts.app')

@section('title', 'Edit Customer | SuperCart PoS')

@section('content')
    <div class="max-w-3xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Customer</h1>
        <p class="mt-2 text-sm text-slate-500">Update customer profile information and loyalty points.</p>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-6 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Name</span>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
            </div>
            <div class="grid gap-6 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Phone</span>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
                <label class="space-y-2 text-sm text-slate-700">
                    <span>Loyalty Points</span>
                    <input type="number" min="0" name="loyalty_points" value="{{ old('loyalty_points', $customer->loyalty_points) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                </label>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">Update Customer</button>
                <a href="{{ route('customers.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
