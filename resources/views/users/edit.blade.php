@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
<form method="POST" action="{{ route('users.update', $user) }}" class="max-w-3xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    @include('users._form', ['user' => $user, 'edit' => true])
    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg">Actualizar</button>
</form>
@endsection
