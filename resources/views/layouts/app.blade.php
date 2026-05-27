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
    $navItems = [
        ['route' => 'dashboard', 'pattern' => 'dashboard', 'label' => 'Dashboard'],
        ['route' => 'projects.index', 'pattern' => 'projects.*', 'label' => 'Proyectos'],
        ['route' => 'expenses.index', 'pattern' => 'expenses.*', 'label' => 'Gastos'],
        ['route' => 'suppliers.index', 'pattern' => 'suppliers.*', 'label' => 'Proveedores'],
        ['route' => 'materials.index', 'pattern' => 'materials.*', 'label' => 'Materiales'],
        ['route' => 'inventory.index', 'pattern' => 'inventory.*', 'label' => 'Inventario'],
        ['route' => 'purchases.index', 'pattern' => 'purchases.*', 'label' => 'Compras'],
        ['route' => 'reports.expenses', 'pattern' => 'reports.*', 'label' => 'Reportes'],
    ];

    if (auth()->user()?->canManageUsers()) {
        $navItems[] = ['route' => 'users.index', 'pattern' => 'users.*', 'label' => 'Usuarios'];
        $navItems[] = ['route' => 'settings.branding.edit', 'pattern' => 'settings.branding.*', 'label' => "Personalizaci\u{00F3}n"];
    }
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
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs($item['pattern']) ? 'bg-slate-800' : '' }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="border-t border-slate-800 p-4 text-xs">
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-slate-400">{{ auth()->user()->role->label }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="text-red-300 hover:text-red-200">Cerrar sesi&oacute;n</button>
            </form>
        </div>
    </aside>

    <main class="flex min-h-screen flex-1 flex-col">
        <header class="border-b border-slate-200 bg-white px-4 py-4 md:px-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="shrink-0 md:hidden">
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

            <details class="mt-4 rounded-xl border border-slate-200 bg-slate-50 md:hidden">
                <summary class="cursor-pointer list-none px-4 py-3 text-sm font-medium text-slate-700">
                    Men&uacute;
                </summary>
                <div class="space-y-2 border-t border-slate-200 px-3 py-3">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-white {{ request()->routeIs($item['pattern']) ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700' }}">{{ $item['label'] }}</a>
                    @endforeach
                    <div class="border-t border-slate-200 pt-3">
                        <p class="px-3 text-xs font-medium text-slate-700">{{ auth()->user()->name }}</p>
                        <p class="px-3 text-xs text-slate-500">{{ auth()->user()->role->label }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
                            @csrf
                            <button type="submit" class="text-sm text-red-600">Cerrar sesi&oacute;n</button>
                        </form>
                    </div>
                </div>
            </details>
        </header>

        <div class="flex-1 p-4 md:p-6">
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

        <footer class="border-t border-slate-200 bg-white px-4 py-4 text-center text-xs text-slate-500 md:px-6">
            <p>{{ $branding['footer_rights'] }}</p>
            <p class="mt-1">{{ $branding['footer_credit'] }}</p>
        </footer>
    </main>
</div>
</body>
</html>
