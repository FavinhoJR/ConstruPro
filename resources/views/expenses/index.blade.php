@extends('layouts.app')

@section('title', 'Gastos')

@section('content')
<div class="flex flex-wrap justify-between gap-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-2">
        <select name="project_id" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todos los proyectos</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>{{ $project->name }}</option>
            @endforeach
        </select>
        <select name="expense_category_id" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todas las categorías</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('expense_category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todos los estados</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="rounded-lg border-slate-300 text-sm">
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="rounded-lg border-slate-300 text-sm">
        <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm">Filtrar</button>
    </form>
    @can('create', App\Models\Expense::class)
        <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Registrar gasto</a>
    @endcan
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3">Proyecto</th>
                <th class="px-4 py-3">Descripción</th>
                <th class="px-4 py-3">Monto</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $expense->project->name }}</td>
                    <td class="px-4 py-3">{{ $expense->description }}</td>
                    <td class="px-4 py-3">Q {{ number_format($expense->amount, 2) }}</td>
                    <td class="px-4 py-3"><x-badge :text="$expense->status->label()" /></td>
                    <td class="px-4 py-3 text-right space-x-2">
                        @can('update', $expense)
                            <a href="{{ route('expenses.edit', $expense) }}" class="underline">Editar</a>
                        @endcan
                        @can('approve', $expense)
                            @if ($expense->status->value === 'pendiente')
                                <form method="POST" action="{{ route('expenses.approve', $expense) }}" class="inline">@csrf<button class="text-emerald-700">Aprobar</button></form>
                                <form method="POST" action="{{ route('expenses.reject', $expense) }}" class="inline">@csrf<input type="hidden" name="rejection_reason" value="Rechazado desde listado"><button class="text-red-700">Rechazar</button></form>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Sin gastos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $expenses->links() }}</div>
@endsection
