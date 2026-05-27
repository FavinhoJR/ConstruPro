@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('purchases.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nueva compra</a>
</div>

<div class="space-y-3 md:hidden">
    @forelse ($purchases as $purchase)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">{{ $purchase->supplier->name }}</p>
                    <h3 class="mt-1 font-semibold text-slate-900">{{ $purchase->project?->name ?? 'Compra general' }}</h3>
                </div>
                <x-badge :text="$purchase->status->label()" />
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Fecha:</span> {{ $purchase->purchase_date->format('d/m/Y') }}</p>
                <p><span class="text-slate-500">Total:</span> Q {{ number_format($purchase->total, 2) }}</p>
            </div>
            <a href="{{ route('purchases.show', $purchase) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">Ver detalle</a>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin compras.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[760px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">Proveedor</th><th class="px-4 py-3">Proyecto</th><th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Estado</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $purchase->supplier->name }}</td>
                        <td class="px-4 py-3">{{ $purchase->project?->name ?? '-' }}</td>
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
</div>
<div class="mt-4">{{ $purchases->links() }}</div>
@endsection
