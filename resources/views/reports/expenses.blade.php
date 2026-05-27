@extends('layouts.app')

@section('title', 'Reporte de gastos')

@section('content')
<form method="GET" class="flex gap-2 mb-6">
    <input type="date" name="from" value="{{ $from }}" class="rounded-lg border-slate-300 text-sm">
    <input type="date" name="to" value="{{ $to }}" class="rounded-lg border-slate-300 text-sm">
    <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm">Filtrar</button>
</form>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Por proyecto</h3>
        @forelse ($byProject as $project)
            <div class="flex justify-between text-sm py-2 border-b border-slate-100">
                <span>{{ $project->name }}</span>
                <span>Q {{ number_format($project->total ?? 0, 2) }}</span>
            </div>
        @empty
            <p class="text-slate-500 text-sm">Sin datos.</p>
        @endforelse
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold mb-4">Por categoría</h3>
        @forelse ($byCategory as $row)
            <div class="flex justify-between text-sm py-2 border-b border-slate-100">
                <span>{{ $row->category->name }}</span>
                <span>Q {{ number_format($row->total, 2) }}</span>
            </div>
        @empty
            <p class="text-slate-500 text-sm">Sin datos.</p>
        @endforelse
    </div>
</div>
@endsection
