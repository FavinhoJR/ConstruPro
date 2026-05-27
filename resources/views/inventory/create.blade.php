@extends('layouts.app')

@section('title', 'Nuevo movimiento')

@section('content')
<form method="POST" action="{{ route('inventory.store') }}" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Material</label>
            <select name="material_id" required class="w-full rounded-lg border-slate-300">
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->name }} ({{ \App\Support\Format::quantity($material->current_stock) }} {{ $material->unit }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Tipo</label>
            <select name="type" required class="w-full rounded-lg border-slate-300">
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Cantidad</label>
            <input type="number" step="0.001" name="quantity" required class="w-full rounded-lg border-slate-300">
        </div>
        <div>
            <label class="block text-sm mb-1">Fecha</label>
            <input type="date" name="movement_date" value="{{ now()->toDateString() }}" required class="w-full rounded-lg border-slate-300">
        </div>
        <div>
            <label class="block text-sm mb-1">Proyecto (opcional)</label>
            <select name="project_id" class="w-full rounded-lg border-slate-300">
                <option value="">—</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">Observación</label>
            <textarea name="notes" rows="2" class="w-full rounded-lg border-slate-300"></textarea>
        </div>
    </div>
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Registrar</button>
</form>
@endsection
