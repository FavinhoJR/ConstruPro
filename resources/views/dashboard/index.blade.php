@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
    <x-stat-card label="Total proyectos" :value="$projectsTotal" />
    <x-stat-card label="Proyectos activos" :value="$activeProjects" />
    <x-stat-card label="Gastos del mes" :value="'Q '.number_format($monthExpenses, 2)" />
    <x-stat-card label="Compras pendientes" :value="$pendingPurchases" />
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">Gasto por proyecto</h3>
        <div class="space-y-3">
            @forelse ($projectSpending as $project)
                <div class="flex justify-between text-sm">
                    <span>{{ $project->name }}</span>
                    <span class="font-medium">Q {{ number_format($project->approved_total ?? 0, 2) }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Sin datos.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">Materiales con stock bajo</h3>
        <div class="space-y-3">
            @forelse ($lowStockMaterials as $material)
                <div class="flex justify-between text-sm">
                    <span>{{ $material->name }}</span>
                    <span class="font-medium text-amber-600">{{ \App\Support\Format::quantity($material->current_stock) }} {{ $material->unit }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Todo el inventario est&aacute; en niveles adecuados.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">&Uacute;ltimos gastos</h3>
        <div class="space-y-3">
            @forelse ($recentExpenses as $expense)
                <div class="text-sm">
                    <p class="font-medium">{{ $expense->description }}</p>
                    <p class="text-slate-500">{{ $expense->project->name }} &middot; Q {{ number_format($expense->amount, 2) }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Sin gastos recientes.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">&Uacute;ltimas evidencias</h3>
        <div class="space-y-3">
            @forelse ($recentDocuments as $doc)
                <div class="text-sm">
                    <p class="font-medium">{{ $doc->original_name }}</p>
                    <p class="text-slate-500">{{ $doc->uploader->name }} &middot; {{ $doc->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Sin documentos recientes.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
