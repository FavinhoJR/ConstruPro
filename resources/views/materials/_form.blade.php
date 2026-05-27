@php($material = $material ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label class="block text-sm mb-1">Codigo</label><input name="code" value="{{ old('code', $material?->code) }}" required class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Nombre</label><input name="name" value="{{ old('name', $material?->name) }}" required class="w-full rounded-lg border-slate-300"></div>
    <div class="md:col-span-2"><label class="block text-sm mb-1">Descripcion</label><textarea name="description" rows="2" class="w-full rounded-lg border-slate-300">{{ old('description', $material?->description) }}</textarea></div>
    <div><label class="block text-sm mb-1">Unidad</label><input name="unit" value="{{ old('unit', $material?->unit) }}" required class="w-full rounded-lg border-slate-300"></div>
    @if (!$material)
        <div><label class="block text-sm mb-1">Stock inicial</label><input type="number" step="0.001" name="current_stock" value="{{ \App\Support\Format::quantityInput(old('current_stock', 0)) }}" class="w-full rounded-lg border-slate-300"></div>
    @endif
    <div><label class="block text-sm mb-1">Stock minimo</label><input type="number" step="0.001" name="minimum_stock" value="{{ \App\Support\Format::quantityInput(old('minimum_stock', $material?->minimum_stock ?? 0)) }}" class="w-full rounded-lg border-slate-300"></div>
    @if (!$material)
        <div><label class="block text-sm mb-1">Costo promedio</label><input type="number" step="0.01" name="average_cost" value="{{ old('average_cost', 0) }}" class="w-full rounded-lg border-slate-300"></div>
    @endif
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $material?->is_active ?? true))>
        <label class="text-sm">Activo</label>
    </div>
</div>
