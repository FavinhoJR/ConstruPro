@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="flex flex-wrap gap-2 mb-6">
    @foreach (['info' => 'Información', 'expenses' => 'Gastos', 'evidences' => 'Evidencias', 'purchases' => 'Compras', 'inventory' => 'Inventario'] as $key => $label)
        <a href="{{ route('projects.show', [$project, 'tab' => $key]) }}"
           class="px-4 py-2 rounded-lg text-sm {{ $tab === $key ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200' }}">
            {{ $label }}
        </a>
    @endforeach
    @can('update', $project)
        <a href="{{ route('projects.edit', $project) }}" class="ml-auto px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm">Editar</a>
    @endcan
</div>

@if ($tab === 'info')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white rounded-xl border border-slate-200 p-6 text-sm">
        <div><span class="text-slate-500">Cliente:</span> {{ $project->client }}</div>
        <div><span class="text-slate-500">Estado:</span> <x-badge :text="$project->status->label()" /></div>
        <div><span class="text-slate-500">Ubicación:</span> {{ $project->location ?? '—' }}</div>
        <div><span class="text-slate-500">Responsable:</span> {{ $project->responsible?->name ?? '—' }}</div>
        <div><span class="text-slate-500">Inicio:</span> {{ $project->start_date->format('d/m/Y') }}</div>
        <div><span class="text-slate-500">Fin estimado:</span> {{ $project->estimated_end_date?->format('d/m/Y') ?? '—' }}</div>
        <div><span class="text-slate-500">Presupuesto:</span> Q {{ number_format($project->estimated_budget, 2) }}</div>
        <div><span class="text-slate-500">Total gastado (aprobado):</span> Q {{ number_format($totalSpent, 2) }}</div>
        <div class="md:col-span-2"><span class="text-slate-500">Descripción:</span> {{ $project->description ?? '—' }}</div>
    </div>
@elseif ($tab === 'expenses')
    @include('projects.partials.expenses', ['expenses' => $project->expenses])
@elseif ($tab === 'evidences')
    @include('projects.partials.evidences', ['documents' => $project->documents])
@elseif ($tab === 'purchases')
    @include('projects.partials.purchases', ['purchases' => $project->purchases])
@else
    @include('projects.partials.inventory', ['movements' => $project->inventoryMovements])
@endif
@endsection
