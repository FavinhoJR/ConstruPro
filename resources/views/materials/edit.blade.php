@extends('layouts.app')

@section('title', 'Editar material')

@section('content')
<form method="POST" action="{{ route('materials.update', $material) }}" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    @include('materials._form', ['material' => $material])
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Actualizar</button>
</form>
@endsection
