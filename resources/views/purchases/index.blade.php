@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('purchases.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nueva compra</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3">Proveedor</th><th class="px-4 py-3">Proyecto</th><th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Estado</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($purchases as $purchase)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $purchase->supplier->name }}</td>
                    <td class="px-4 py-3">{{ $purchase->project?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">Q {{ number_format($purchase->total, 2) }}</td>
                    <td class="px-4 py-3"><x-badge :text="$purchase->status->label()" /></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('purchases.show', $purchase) }}" class="underline">Ver</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">Sin compras.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $purchases->links() }}</div>
@endsection
