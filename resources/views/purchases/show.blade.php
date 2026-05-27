@extends('layouts.app')

@section('title', 'Compra #'.$purchase->id)

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 mb-6 text-sm grid grid-cols-1 md:grid-cols-2 gap-3">
    <div><span class="text-slate-500">Proveedor:</span> {{ $purchase->supplier->name }}</div>
    <div><span class="text-slate-500">Proyecto:</span> {{ $purchase->project?->name ?? '—' }}</div>
    <div><span class="text-slate-500">Fecha:</span> {{ $purchase->purchase_date->format('d/m/Y') }}</div>
    <div><span class="text-slate-500">Estado:</span> <x-badge :text="$purchase->status->label()" /></div>
    <div><span class="text-slate-500">Total:</span> Q {{ number_format($purchase->total, 2) }}</div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
    <table class="w-full text-sm">
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

@if ($purchase->status->value === 'pendiente')
    <div class="flex gap-3">
        <form method="POST" action="{{ route('purchases.receive', $purchase) }}">@csrf<button class="px-4 py-2 bg-emerald-700 text-white rounded-lg">Marcar recibida</button></form>
        <form method="POST" action="{{ route('purchases.cancel', $purchase) }}">@csrf<button class="px-4 py-2 bg-red-700 text-white rounded-lg">Anular</button></form>
    </div>
@endif

@if ($purchase->documents->isNotEmpty())
    <div class="mt-6">
        <h3 class="font-medium mb-2">Documentos</h3>
        @foreach ($purchase->documents as $doc)
            <a href="{{ $doc->url() }}" target="_blank" class="text-sm underline block">{{ $doc->original_name }}</a>
        @endforeach
    </div>
@endif
@endsection
