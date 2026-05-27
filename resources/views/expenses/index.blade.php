@extends('layouts.app')

@section('title', 'Gastos')

@section('content')
<div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
    <form method="GET" class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">
        <select name="project_id" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todos los proyectos</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>{{ $project->name }}</option>
            @endforeach
        </select>
        <select name="expense_category_id" class="rounded-lg border-slate-300 text-sm">
            <option value="">Todas las categor&iacute;as</option>
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
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white">Filtrar</button>
    </form>
    @can('create', App\Models\Expense::class)
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Registrar gasto</a>
    @endcan
</div>

<div class="space-y-3 md:hidden">
    @forelse ($expenses as $expense)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-500">{{ $expense->project->name }}</p>
                    <h3 class="mt-1 font-semibold text-slate-900">{{ $expense->description }}</h3>
                </div>
                <x-badge :text="$expense->status->label()" />
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Monto:</span> Q {{ number_format($expense->amount, 2) }}</p>
                <p><span class="text-slate-500">Fecha:</span> {{ $expense->expense_date->format('d/m/Y') }}</p>
            </div>
            <div class="mt-4 flex flex-wrap gap-3 text-sm">
                @can('update', $expense)
                    <a href="{{ route('expenses.edit', $expense) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-slate-700">Editar</a>
                @endcan
                @can('approve', $expense)
                    @if ($expense->status->value === 'pendiente')
                        <form method="POST" action="{{ route('expenses.approve', $expense) }}" class="flex-1">
                            @csrf
                            <button class="w-full rounded-lg bg-emerald-700 px-3 py-2 text-white">Aprobar</button>
                        </form>
                        <form method="POST" action="{{ route('expenses.reject', $expense) }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="rejection_reason" value="Rechazado desde listado">
                            <button class="w-full rounded-lg bg-red-700 px-3 py-2 text-white">Rechazar</button>
                        </form>
                    @endif
                @endcan
            </div>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin gastos.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[720px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3">Proyecto</th>
                    <th class="px-4 py-3">Descripci&oacute;n</th>
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
                        <td class="space-x-2 px-4 py-3 text-right">
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
</div>
<div class="mt-4">{{ $expenses->links() }}</div>
@endsection
