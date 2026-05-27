@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <form method="GET" class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..."
               class="rounded-lg border-slate-300 text-sm">
        <select name="status" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todos los estados</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white sm:w-auto">Filtrar</button>
    </form>
    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nuevo proyecto</a>
    @endcan
</div>

<div class="space-y-3 md:hidden">
    @forelse ($projects as $project)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-slate-900">{{ $project->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $project->client }}</p>
                </div>
                <x-badge :text="$project->status->label()" />
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Presupuesto:</span> Q {{ number_format($project->estimated_budget, 2) }}</p>
            </div>
            <a href="{{ route('projects.show', $project) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">Ver detalle</a>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">No hay proyectos.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[640px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3">Proyecto</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Presupuesto</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $project->name }}</td>
                        <td class="px-4 py-3">{{ $project->client }}</td>
                        <td class="px-4 py-3"><x-badge :text="$project->status->label()" /></td>
                        <td class="px-4 py-3">Q {{ number_format($project->estimated_budget, 2) }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('projects.show', $project) }}" class="text-slate-700 hover:underline">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">No hay proyectos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $projects->links() }}</div>
@endsection
