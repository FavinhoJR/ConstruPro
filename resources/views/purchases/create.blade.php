@extends('layouts.app')

@section('title', 'Nueva compra')

@section('content')
<form method="POST" action="{{ route('purchases.store') }}" enctype="multipart/form-data" class="max-w-4xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Proveedor</label>
            <select name="supplier_id" required class="w-full rounded-lg border-slate-300">
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Proyecto (opcional)</label>
            <select name="project_id" class="w-full rounded-lg border-slate-300">
                <option value="">—</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Fecha</label>
            <input type="date" name="purchase_date" value="{{ now()->toDateString() }}" required class="w-full rounded-lg border-slate-300">
        </div>
        <div>
            <label class="block text-sm mb-1">Documento</label>
            <input type="file" name="document" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm">
        </div>
    </div>

    <div id="items" class="space-y-3">
        <h3 class="font-medium">Detalle</h3>
        <div class="grid grid-cols-12 gap-2 item-row">
            <div class="col-span-5">
                <select name="items[0][material_id]" required class="w-full rounded-lg border-slate-300 text-sm">
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3"><input type="number" step="0.001" name="items[0][quantity]" placeholder="Cantidad" required class="w-full rounded-lg border-slate-300 text-sm"></div>
            <div class="col-span-4"><input type="number" step="0.01" name="items[0][unit_cost]" placeholder="Costo unitario" required class="w-full rounded-lg border-slate-300 text-sm"></div>
        </div>
    </div>

    <button type="button" onclick="addItem()" class="text-sm text-slate-600 underline">+ Agregar línea</button>
    <button type="submit" class="block px-4 py-2 bg-slate-900 text-white rounded-lg">Guardar compra</button>
</form>

<script>
let itemIndex = 1;
function addItem() {
    const container = document.getElementById('items');
    const row = container.querySelector('.item-row').cloneNode(true);
    row.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace(/\[\d+\]/, `[${itemIndex}]`);
        if (el.tagName === 'INPUT') el.value = '';
    });
    container.appendChild(row);
    itemIndex++;
}
</script>
@endsection
