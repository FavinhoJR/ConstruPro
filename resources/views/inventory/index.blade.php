@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('inventory.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nuevo movimiento</a>
</div>

<div class="space-y-3 md:hidden">
    @forelse ($movements as $movement)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">{{ $movement->type->label() }}</p>
                    <h3 class="mt-1 font-semibold text-slate-900">{{ $movement->material->name }}</h3>
                </div>
                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">{{ \App\Support\Format::quantity($movement->quantity) }}</span>
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Proyecto:</span> {{ $movement->project?->name ?? '-' }}</p>
                <p><span class="text-slate-500">Fecha:</span> {{ $movement->movement_date->format('d/m/Y') }}</p>
            </div>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin movimientos.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[680px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">Material</th><th class="px-4 py-3">Tipo</th><th class="px-4 py-3">Cantidad</th><th class="px-4 py-3">Proyecto</th><th class="px-4 py-3">Fecha</th></tr>
            </thead>
            <tbody>
                @forelse ($movements as $movement)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $movement->material->name }}</td>
                        <td class="px-4 py-3">{{ $movement->type->label() }}</td>
                        <td class="px-4 py-3">{{ \App\Support\Format::quantity($movement->quantity) }}</td>
                        <td class="px-4 py-3">{{ $movement->project?->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $movement->movement_date->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Sin movimientos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $movements->links() }}</div>
@endsection
