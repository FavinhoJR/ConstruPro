@extends('layouts.app')

@section('title', 'Editar proyecto')

@section('content')
<form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    @include('projects._form', ['project' => $project])
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Actualizar</button>
</form>
@endsection
