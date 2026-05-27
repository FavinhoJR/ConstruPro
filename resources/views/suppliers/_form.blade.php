@php($supplier = $supplier ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label class="block text-sm mb-1">Nombre</label><input name="name" value="{{ old('name', $supplier?->name) }}" required class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">NIT</label><input name="tax_id" value="{{ old('tax_id', $supplier?->tax_id) }}" class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Teléfono</label><input name="phone" value="{{ old('phone', $supplier?->phone) }}" class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Correo</label><input type="email" name="email" value="{{ old('email', $supplier?->email) }}" class="w-full rounded-lg border-slate-300"></div>
    <div class="md:col-span-2"><label class="block text-sm mb-1">Dirección</label><input name="address" value="{{ old('address', $supplier?->address) }}" class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Contacto principal</label><input name="primary_contact" value="{{ old('primary_contact', $supplier?->primary_contact) }}" class="w-full rounded-lg border-slate-300"></div>
    <div class="md:col-span-2"><label class="block text-sm mb-1">Observaciones</label><textarea name="notes" rows="3" class="w-full rounded-lg border-slate-300">{{ old('notes', $supplier?->notes) }}</textarea></div>
</div>
