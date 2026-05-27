@extends('layouts.app')

@section('title', 'Reporte de gastos')

@section('content')
<form method="GET" class="mb-6 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
    <input type="date" name="from" value="{{ $from }}" class="rounded-lg border-slate-300 text-sm">
    <input type="date" name="to" value="{{ $to }}" class="rounded-lg border-slate-300 text-sm">
    <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white">Filtrar</button>
</form>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">Por proyecto</h3>
        @forelse ($byProject as $project)
            <div class="flex justify-between border-b border-slate-100 py-2 text-sm">
                <span>{{ $project->name }}</span>
                <span>Q {{ number_format($project->total ?? 0, 2) }}</span>
            </div>
        @empty
            <p class="text-sm text-slate-500">Sin datos.</p>
        @endforelse
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="mb-4 font-semibold">Por categor&iacute;a</h3>
        @forelse ($byCategory as $row)
            <div class="flex justify-between border-b border-slate-100 py-2 text-sm">
                <span>{{ $row->category->name }}</span>
                <span>Q {{ number_format($row->total, 2) }}</span>
            </div>
        @empty
            <p class="text-sm text-slate-500">Sin datos.</p>
        @endforelse
    </div>
</div>
@endsection
