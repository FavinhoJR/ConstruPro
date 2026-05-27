@extends('layouts.app')

@section('title', 'Editar gasto')

@section('content')
<form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    @include('expenses._form', ['expense' => $expense])
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Actualizar</button>
</form>
@endsection
