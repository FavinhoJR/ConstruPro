@extends('layouts.app')

@section('title', 'Materiales')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('materials.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nuevo material</a>
</div>

<div class="space-y-3 md:hidden">
    @forelse ($materials as $material)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm {{ $material->isLowStock() ? 'bg-amber-50' : '' }}">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">C&oacute;digo: {{ $material->code }}</p>
                    <h3 class="mt-1 font-semibold text-slate-900">{{ $material->name }}</h3>
                </div>
                @if ($material->isLowStock())
                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-medium text-amber-700">Stock bajo</span>
                @endif
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Stock actual:</span> {{ \App\Support\Format::quantity($material->current_stock) }} {{ $material->unit }}</p>
                <p><span class="text-slate-500">Stock m&iacute;nimo:</span> {{ \App\Support\Format::quantity($material->minimum_stock) }}</p>
            </div>
            <a href="{{ route('materials.edit', $material) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">Editar</a>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin materiales.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[640px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">C&oacute;digo</th><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Stock</th><th class="px-4 py-3">M&iacute;nimo</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($materials as $material)
                    <tr class="border-t {{ $material->isLowStock() ? 'bg-amber-50' : '' }}">
                        <td class="px-4 py-3">{{ $material->code }}</td>
                        <td class="px-4 py-3">{{ $material->name }}</td>
                        <td class="px-4 py-3">{{ \App\Support\Format::quantity($material->current_stock) }} {{ $material->unit }}</td>
                        <td class="px-4 py-3">{{ \App\Support\Format::quantity($material->minimum_stock) }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('materials.edit', $material) }}" class="underline">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Sin materiales.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $materials->links() }}</div>
@endsection
