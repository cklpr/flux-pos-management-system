<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FLUX PoS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0F172A; color: #E2E8F0; font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-[32px] border border-slate-800 bg-slate-950/95 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-sm">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-semibold tracking-tight text-white">FLUX PoS</h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-600 bg-rose-950/10 p-4 text-sm text-rose-200">
                <p class="font-semibold">Login failed</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}" data-loading class="space-y-5">
            @csrf

            <label class="block text-sm font-medium text-slate-300">
                Email
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error" class="mt-2 w-full rounded-3xl border border-slate-700 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" />
            </label>

            <label class="block text-sm font-medium text-slate-300">
                Password
                <input type="password" id="password" name="password" required aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="password-error" class="mt-2 w-full rounded-3xl border border-slate-700 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" />
            </label>

            <div class="flex items-center justify-between text-sm text-slate-400">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-600 bg-slate-800 text-cyan-500 focus:ring-cyan-500" />
                    Remember me
                </label>
                <span>Use <strong>admin@fluxpos.test</strong> / password</span>
            </div>

            <button type="submit" data-submit class="w-full rounded-3xl bg-cyan-500 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Sign In</button>
        </form>
    </div>
</body>
</html>
