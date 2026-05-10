@extends('layouts.app')

@section('title', 'Customers | SuperCart PoS')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Customers</h1>
                <p class="mt-1 text-sm text-slate-500">Track customer profiles, history, loyalty points, and contact information.</p>
            </div>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">Add Customer</a>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Sales</th>
                        <th class="px-4 py-3">Loyalty</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $customer->name }}</td>
                            <td class="px-4 py-4">{{ $customer->email ?? '—' }}</td>
                            <td class="px-4 py-4">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-4 py-4">{{ $customer->sales_count }}</td>
                            <td class="px-4 py-4">{{ $customer->loyalty_points }}</td>
                            <td class="px-4 py-4 space-x-2">
                                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-700">Edit</a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Remove this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">No customers yet. Use the button above to add new profiles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $customers->links() }}</div>
    </div>
@endsection
