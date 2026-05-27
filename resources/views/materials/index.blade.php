@extends('layouts.app')

@section('title', 'Materiales')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('materials.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nuevo material</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3">Código</th><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Stock</th><th class="px-4 py-3">Mínimo</th><th></th></tr>
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
<div class="mt-4">{{ $materials->links() }}</div>
@endsection
