@php($project = $project ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $project?->name) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Cliente</label>
        <input type="text" name="client" value="{{ old('client', $project?->client) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Descripción</label>
        <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300">{{ old('description', $project?->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Ubicación</label>
        <input type="text" name="location" value="{{ old('location', $project?->location) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Responsable</label>
        <select name="responsible_id" class="w-full rounded-lg border-slate-300">
            <option value="">Sin asignar</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('responsible_id', $project?->responsible_id) == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Fecha inicio</label>
        <input type="date" name="start_date" value="{{ old('start_date', optional($project?->start_date)->format('Y-m-d')) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Fecha estimada fin</label>
        <input type="date" name="estimated_end_date" value="{{ old('estimated_end_date', optional($project?->estimated_end_date)->format('Y-m-d')) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Estado</label>
        <select name="status" class="w-full rounded-lg border-slate-300">
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $project?->status?->value ?? 'planificacion') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Presupuesto estimado</label>
        <input type="number" step="0.01" name="estimated_budget" value="{{ old('estimated_budget', $project?->estimated_budget ?? 0) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Evidencias (fotos/PDF)</label>
        <input type="file" name="documents[]" multiple accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm">
    </div>
</div>
