@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('suppliers.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Nuevo proveedor</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">NIT</th><th class="px-4 py-3">Contacto</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $supplier->name }}</td>
                    <td class="px-4 py-3">{{ $supplier->tax_id ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $supplier->primary_contact ?? '—' }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('suppliers.edit', $supplier) }}" class="underline">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Sin proveedores.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $suppliers->links() }}</div>
@endsection
