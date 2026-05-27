@extends('layouts.app')

@section('title', 'Compra #'.$purchase->id)

@section('content')
<div class="mb-6 grid grid-cols-1 gap-3 rounded-xl border border-slate-200 bg-white p-4 text-sm md:grid-cols-2 md:p-6">
    <div><span class="text-slate-500">Proveedor:</span> {{ $purchase->supplier->name }}</div>
    <div><span class="text-slate-500">Proyecto:</span> {{ $purchase->project?->name ?? '-' }}</div>
    <div><span class="text-slate-500">Fecha:</span> {{ $purchase->purchase_date->format('d/m/Y') }}</div>
    <div><span class="text-slate-500">Estado:</span> <x-badge :text="$purchase->status->label()" /></div>
    <div><span class="text-slate-500">Total:</span> Q {{ number_format($purchase->total, 2) }}</div>
</div>

<div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-[640px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">Material</th><th class="px-4 py-3">Cantidad</th><th class="px-4 py-3">Costo</th><th class="px-4 py-3">Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($purchase->items as $item)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $item->material->name }}</td>
                        <td class="px-4 py-3">{{ \App\Support\Format::quantity($item->quantity) }}</td>
                        <td class="px-4 py-3">Q {{ number_format($item->unit_cost, 2) }}</td>
                        <td class="px-4 py-3">Q {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($purchase->status->value === 'pendiente')
    <div class="flex flex-col gap-3 sm:flex-row">
        <form method="POST" action="{{ route('purchases.receive', $purchase) }}">@csrf<button class="w-full rounded-lg bg-emerald-700 px-4 py-2 text-white">Marcar recibida</button></form>
        <form method="POST" action="{{ route('purchases.cancel', $purchase) }}">@csrf<button class="w-full rounded-lg bg-red-700 px-4 py-2 text-white">Anular</button></form>
    </div>
@endif

@if ($purchase->documents->isNotEmpty())
    <div class="mt-6">
        <h3 class="mb-2 font-medium">Documentos</h3>
        @foreach ($purchase->documents as $doc)
            <a href="{{ $doc->url() }}" target="_blank" class="block text-sm underline">{{ $doc->original_name }}</a>
        @endforeach
    </div>
@endif
@endsection
