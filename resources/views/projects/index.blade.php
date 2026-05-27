@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..."
               class="rounded-lg border-slate-300 text-sm">
        <select name="status" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todos los estados</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm">Filtrar</button>
    </form>
    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nuevo proyecto</a>
    @endcan
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
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
<div class="mt-4">{{ $projects->links() }}</div>
@endsection
