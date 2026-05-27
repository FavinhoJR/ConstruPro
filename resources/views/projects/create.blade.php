@extends('layouts.app')

@section('title', 'Nuevo proyecto')

@section('content')
<form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @include('projects._form')
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Guardar</button>
</form>
@endsection
