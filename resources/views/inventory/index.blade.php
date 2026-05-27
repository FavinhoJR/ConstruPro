@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nuevo movimiento</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3">Material</th><th class="px-4 py-3">Tipo</th><th class="px-4 py-3">Cantidad</th><th class="px-4 py-3">Proyecto</th><th class="px-4 py-3">Fecha</th></tr>
        </thead>
        <tbody>
            @forelse ($movements as $movement)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $movement->material->name }}</td>
                    <td class="px-4 py-3">{{ $movement->type->label() }}</td>
                    <td class="px-4 py-3">{{ \App\Support\Format::quantity($movement->quantity) }}</td>
                    <td class="px-4 py-3">{{ $movement->project?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $movement->movement_date->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Sin movimientos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $movements->links() }}</div>
@endsection
