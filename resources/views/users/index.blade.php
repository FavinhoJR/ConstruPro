@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nuevo usuario</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Correo</th><th class="px-4 py-3">Rol</th><th class="px-4 py-3">Estado</th><th></th></tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->role->label }}</td>
                    <td class="px-4 py-3">{{ $user->is_active ? 'Activo' : 'Inactivo' }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('users.edit', $user) }}" class="underline">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
