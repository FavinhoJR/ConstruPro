@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="mb-6 flex flex-wrap gap-2">
    @foreach (['info' => "Informaci\u{00F3}n", 'expenses' => 'Gastos', 'evidences' => 'Evidencias', 'purchases' => 'Compras', 'inventory' => 'Inventario'] as $key => $label)
        <a href="{{ route('projects.show', [$project, 'tab' => $key]) }}"
           class="rounded-lg px-4 py-2 text-sm {{ $tab === $key ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-white' }}">
            {{ $label }}
        </a>
    @endforeach
    @can('update', $project)
        <a href="{{ route('projects.edit', $project) }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-center text-sm sm:ml-auto sm:w-auto">Editar</a>
    @endcan
</div>

@if ($tab === 'info')
    <div class="grid grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-white p-4 text-sm md:grid-cols-2 md:p-6">
        <div><span class="text-slate-500">Cliente:</span> {{ $project->client }}</div>
        <div><span class="text-slate-500">Estado:</span> <x-badge :text="$project->status->label()" /></div>
        <div><span class="text-slate-500">Ubicaci&oacute;n:</span> {{ $project->location ?? '-' }}</div>
        <div><span class="text-slate-500">Responsable:</span> {{ $project->responsible?->name ?? '-' }}</div>
        <div><span class="text-slate-500">Inicio:</span> {{ $project->start_date->format('d/m/Y') }}</div>
        <div><span class="text-slate-500">Fin estimado:</span> {{ $project->estimated_end_date?->format('d/m/Y') ?? '-' }}</div>
        <div><span class="text-slate-500">Presupuesto:</span> Q {{ number_format($project->estimated_budget, 2) }}</div>
        <div><span class="text-slate-500">Total gastado (aprobado):</span> Q {{ number_format($totalSpent, 2) }}</div>
        <div class="md:col-span-2"><span class="text-slate-500">Descripci&oacute;n:</span> {{ $project->description ?? '-' }}</div>
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
