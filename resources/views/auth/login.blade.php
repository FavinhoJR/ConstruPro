<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesi&oacute;n - {{ $branding['company_name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-900 p-4">
@php
    $brandInitials = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($branding['company_name'], 0, 2));
@endphp
<div class="flex flex-1 items-center justify-center">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
        <div class="mb-8 text-center">
            <div class="mb-4 flex justify-center">
                @if ($branding['logo_url'])
                    <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['company_name'] }}" class="h-16 w-16 rounded-2xl border border-slate-200 bg-white object-contain p-2">
                @else
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-900 text-lg font-bold tracking-[0.25em] text-white">
                        {{ $brandInitials }}
                    </div>
                @endif
            </div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $branding['company_name'] }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $branding['tagline'] }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Correo</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-lg border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Contrase&ntilde;a</label>
                <input type="password" name="password" required
                       class="w-full rounded-lg border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300">
                Recordarme
            </label>
            <button type="submit" class="w-full rounded-lg bg-slate-900 py-2.5 font-medium text-white hover:bg-slate-800">
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-400">
            Demo: admin@construpro.local / password
        </p>
    </div>
</div>
<footer class="pb-2 text-center text-xs text-slate-300">
    <p>{{ $branding['footer_rights'] }}</p>
    <p class="mt-1">{{ $branding['footer_credit'] }}</p>
</footer>
</body>
</html>
