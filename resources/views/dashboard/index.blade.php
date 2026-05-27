@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <x-stat-card label="Total proyectos" :value="$projectsTotal" />
    <x-stat-card label="Proyectos activos" :value="$activeProjects" />
    <x-stat-card label="Gastos del mes" :value="'Q '.number_format($monthExpenses, 2)" />
    <x-stat-card label="Compras pendientes" :value="$pendingPurchases" />
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Gasto por proyecto</h3>
        <div class="space-y-3">
            @forelse ($projectSpending as $project)
                <div class="flex justify-between text-sm">
                    <span>{{ $project->name }}</span>
                    <span class="font-medium">Q {{ number_format($project->approved_total ?? 0, 2) }}</span>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Sin datos.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Materiales con stock bajo</h3>
        <div class="space-y-3">
            @forelse ($lowStockMaterials as $material)
                <div class="flex justify-between text-sm">
                    <span>{{ $material->name }}</span>
                    <span class="text-amber-600 font-medium">{{ \App\Support\Format::quantity($material->current_stock) }} {{ $material->unit }}</span>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Todo el inventario está en niveles adecuados.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Últimos gastos</h3>
        <div class="space-y-3">
            @forelse ($recentExpenses as $expense)
                <div class="text-sm">
                    <p class="font-medium">{{ $expense->description }}</p>
                    <p class="text-slate-500">{{ $expense->project->name }} · Q {{ number_format($expense->amount, 2) }}</p>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Sin gastos recientes.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Últimas evidencias</h3>
        <div class="space-y-3">
            @forelse ($recentDocuments as $doc)
                <div class="text-sm">
                    <p class="font-medium">{{ $doc->original_name }}</p>
                    <p class="text-slate-500">{{ $doc->uploader->name }} · {{ $doc->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Sin documentos recientes.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
