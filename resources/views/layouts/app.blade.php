<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ $branding['company_name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
@php
    $brandInitials = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($branding['company_name'], 0, 2));
@endphp
<div class="min-h-screen flex">
    <aside class="hidden w-72 border-r border-slate-800 bg-slate-950 text-slate-100 md:flex md:flex-col">
        <div class="border-b border-slate-800 p-6">
            <div class="flex items-center gap-4">
                @if ($branding['logo_url'])
                    <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['company_name'] }}" class="h-12 w-12 rounded-xl border border-slate-700 bg-white object-contain p-1">
                @else
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-800 text-sm font-bold tracking-[0.2em] text-slate-100">
                        {{ $brandInitials }}
                    </div>
                @endif
                <div class="min-w-0">
                    <h1 class="truncate text-lg font-semibold tracking-tight">{{ $branding['company_name'] }}</h1>
                    <p class="mt-1 text-xs text-slate-400">{{ $branding['tagline'] }}</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 space-y-1 p-4 text-sm">
            <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}">Dashboard</a>
            <a href="{{ route('projects.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('projects.*') ? 'bg-slate-800' : '' }}">Proyectos</a>
            <a href="{{ route('expenses.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('expenses.*') ? 'bg-slate-800' : '' }}">Gastos</a>
            <a href="{{ route('suppliers.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('suppliers.*') ? 'bg-slate-800' : '' }}">Proveedores</a>
            <a href="{{ route('materials.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('materials.*') ? 'bg-slate-800' : '' }}">Materiales</a>
            <a href="{{ route('inventory.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('inventory.*') ? 'bg-slate-800' : '' }}">Inventario</a>
            <a href="{{ route('purchases.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('purchases.*') ? 'bg-slate-800' : '' }}">Compras</a>
            <a href="{{ route('reports.expenses') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('reports.*') ? 'bg-slate-800' : '' }}">Reportes</a>
            @can('manage-users')
                <a href="{{ route('users.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('users.*') ? 'bg-slate-800' : '' }}">Usuarios</a>
                <a href="{{ route('settings.branding.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('settings.branding.*') ? 'bg-slate-800' : '' }}">Personalizacion</a>
            @endcan
        </nav>
        <div class="border-t border-slate-800 p-4 text-xs">
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-slate-400">{{ auth()->user()->role->label }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="text-red-300 hover:text-red-200">Cerrar sesion</button>
            </form>
        </div>
    </aside>

    <main class="flex min-h-screen flex-1 flex-col">
        <header class="border-b border-slate-200 bg-white px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="md:hidden">
                        @if ($branding['logo_url'])
                            <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['company_name'] }}" class="h-10 w-10 rounded-lg border border-slate-200 bg-white object-contain p-1">
                        @else
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-900 text-xs font-bold tracking-[0.2em] text-white">
                                {{ $brandInitials }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium uppercase tracking-[0.25em] text-slate-500">{{ $branding['company_name'] }}</p>
                        <h2 class="truncate text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</h2>
                    </div>
                </div>
                <div class="hidden text-right md:block">
                    <p class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ $branding['tagline'] }}</p>
                </div>
            </div>
        </header>

        <div class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>

        <footer class="border-t border-slate-200 bg-white px-6 py-4 text-center text-xs text-slate-500">
            <p>{{ $branding['footer_rights'] }}</p>
            <p class="mt-1">{{ $branding['footer_credit'] }}</p>
        </footer>
    </main>
</div>
</body>
</html>
