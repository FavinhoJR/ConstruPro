@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nuevo usuario</a>
</div>

<div class="space-y-3 md:hidden">
    @forelse ($users as $user)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-slate-900">{{ $user->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                </div>
                <span class="rounded-full {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }} px-2 py-1 text-xs font-medium">
                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">Rol:</span> {{ $user->role->label }}</p>
            </div>
            <a href="{{ route('users.edit', $user) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">Editar</a>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin usuarios.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[680px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Correo</th><th class="px-4 py-3">Rol</th><th class="px-4 py-3">Estado</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->role->label }}</td>
                        <td class="px-4 py-3">{{ $user->is_active ? 'Activo' : 'Inactivo' }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('users.edit', $user) }}" class="underline">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Sin usuarios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
