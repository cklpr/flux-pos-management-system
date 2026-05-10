<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FLUX PoS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0F172A; color: #E2E8F0; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        a { transition: color 0.2s ease, background-color 0.2s ease; }
        .toast-show { animation: toast-in 0.4s ease forwards; }
        @keyframes toast-in { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
        @media print {
            body { background: #fff; color: #000; }
            header, footer, .no-print, .print-hidden { display: none !important; }
            .print-area { box-shadow: none !important; border: none !important; background: transparent !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="no-print bg-slate-950 text-slate-100 shadow-lg shadow-slate-900/40">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('pos.index') }}" class="text-2xl font-semibold tracking-tight text-white">FLUX PoS</a>
                    <p class="mt-1 text-sm text-slate-400">All-in-one POS platform for sales, inventory, customers, and insights.</p>
                </div>
                @auth
                    <button id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-900 px-4 py-2 text-sm font-semibold text-slate-200 md:hidden">
                        Menu
                        <span class="text-cyan-400">☰</span>
                    </button>
                    <div class="hidden md:flex md:items-center md:gap-4">
                        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-slate-300">
                            <a href="{{ route('products.index') }}" class="rounded-full bg-slate-800 px-3 py-2 hover:bg-cyan-500 hover:text-slate-950">Products</a>
                            <a href="{{ route('customers.index') }}" class="rounded-full bg-slate-800 px-3 py-2 hover:bg-cyan-500 hover:text-slate-950">Customers</a>
                            <a href="{{ route('sales.create') }}" class="rounded-full bg-slate-800 px-3 py-2 hover:bg-cyan-500 hover:text-slate-950">New Sale</a>
                            <a href="{{ route('reports.index') }}" class="rounded-full bg-slate-800 px-3 py-2 hover:bg-cyan-500 hover:text-slate-950">Reports</a>
                        </nav>
                        <div class="flex items-center gap-3 rounded-3xl border border-slate-800 bg-slate-900 px-4 py-2 text-sm text-slate-300 shadow-sm">
                            <span>Admin</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-full bg-slate-700 px-3 py-2 text-sm text-white hover:bg-slate-600">Sign out</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
            @auth
                <div id="mobile-menu" class="mt-4 hidden flex-col gap-3 rounded-3xl border border-slate-800 bg-slate-950/95 p-4 text-sm text-slate-300 md:hidden">
                    <a href="{{ route('products.index') }}" class="block rounded-2xl bg-slate-900 px-4 py-2 hover:bg-cyan-500 hover:text-slate-950">Products</a>
                    <a href="{{ route('customers.index') }}" class="block rounded-2xl bg-slate-900 px-4 py-2 hover:bg-cyan-500 hover:text-slate-950">Customers</a>
                    <a href="{{ route('sales.create') }}" class="block rounded-2xl bg-slate-900 px-4 py-2 hover:bg-cyan-500 hover:text-slate-950">New Sale</a>
                    <a href="{{ route('reports.index') }}" class="block rounded-2xl bg-slate-900 px-4 py-2 hover:bg-cyan-500 hover:text-slate-950">Reports</a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">Sign out</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-100 shadow-sm">
                <strong class="font-semibold">Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-100 shadow-sm">
                <strong class="font-semibold">Error:</strong> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @if (session('success') || session('error'))
        <div id="toast-message" role="status" aria-live="polite" class="toast-show fixed right-4 top-4 z-50 max-w-sm rounded-3xl border px-5 py-4 shadow-2xl transition-all duration-300">
            @if(session('success'))
                <div class="text-sm font-semibold text-emerald-800">Success</div>
                <p class="mt-1 text-sm text-emerald-900">{{ session('success') }}</p>
            @else
                <div class="text-sm font-semibold text-rose-800">Error</div>
                <p class="mt-1 text-sm text-rose-900">{{ session('error') }}</p>
            @endif
        </div>
    @endif

        <footer class="no-print bg-slate-950 text-slate-400 border-t border-slate-800/50 mt-16">
            <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-3 mb-8">
                    <div>
                        <h3 class="text-white font-semibold">FLUX PoS</h3>
                        <p class="mt-2 text-sm text-slate-500">FLUX PoS is a modern point-of-sale and inventory management system designed for retail stores, school supply shops, and small businesses.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm mb-3">Navigation</h4>
                        <ul class="space-y-2 text-sm text-slate-500">
                            <li><a href="{{ route('products.index') }}" class="hover:text-slate-300">Products</a></li>
                            <li><a href="{{ route('sales.create') }}" class="hover:text-slate-300">New Sale</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm mb-3">Resources</h4>
                        <ul class="space-y-2 text-sm text-slate-500">
                            <li><a href="{{ route('customers.index') }}" class="hover:text-slate-300">Customers</a></li>
                            <li><a href="{{ route('reports.index') }}" class="hover:text-slate-300">Reports</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-slate-800/50 pt-8 text-center text-sm text-slate-500">
                    <p>&copy; {{ date('Y') }} FLUX PoS. All rights reserved.</p>
                </div>
            </div>
        </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', function () {
                    const expanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                    mobileMenu.classList.toggle('hidden');
                });
            }

            document.querySelectorAll('form[data-loading]').forEach(function (form) {
                form.addEventListener('submit', function () {
                    const button = form.querySelector('[data-submit]');
                    if (!button) return;
                    button.disabled = true;
                    button.classList.add('cursor-wait', 'opacity-80');
                    button.innerHTML = '<span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent mr-2"></span>' + button.textContent.trim();
                });
            });

            const toast = document.getElementById('toast-message');
            if (toast) {
                setTimeout(function () { toast.classList.add('opacity-0'); }, 5000);
            }
        });
    </script>
</body>
</html>
