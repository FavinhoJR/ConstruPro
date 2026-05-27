@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('suppliers.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Nuevo proveedor</a>
</div>

<div class="space-y-3 md:hidden">
    @forelse ($suppliers as $supplier)
        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <h3 class="font-semibold text-slate-900">{{ $supplier->name }}</h3>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p><span class="text-slate-500">NIT:</span> {{ $supplier->tax_id ?? '-' }}</p>
                <p><span class="text-slate-500">Contacto:</span> {{ $supplier->primary_contact ?? '-' }}</p>
            </div>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700">Editar</a>
        </article>
    @empty
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-8 text-center text-slate-500">Sin proveedores.</div>
    @endforelse
</div>

<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white md:block">
    <div class="overflow-x-auto">
        <table class="min-w-[560px] w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">NIT</th><th class="px-4 py-3">Contacto</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $supplier->name }}</td>
                        <td class="px-4 py-3">{{ $supplier->tax_id ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $supplier->primary_contact ?? '-' }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('suppliers.edit', $supplier) }}" class="underline">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Sin proveedores.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $suppliers->links() }}</div>
@endsection
