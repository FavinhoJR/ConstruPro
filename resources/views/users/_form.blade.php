@php($user = $user ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label class="block text-sm mb-1">Nombre</label><input name="name" value="{{ old('name', $user?->name) }}" required class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Correo</label><input type="email" name="email" value="{{ old('email', $user?->email) }}" required class="w-full rounded-lg border-slate-300"></div>
    <div>
        <label class="block text-sm mb-1">Rol</label>
        <select name="role_id" required class="w-full rounded-lg border-slate-300">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(old('role_id', $user?->role_id) == $role->id)>{{ $role->label }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex items-center gap-2 pt-6">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user?->is_active ?? true))>
        <label class="text-sm">Activo</label>
    </div>
    <div><label class="block text-sm mb-1">Contraseña {{ isset($edit) ? '(opcional)' : '' }}</label><input type="password" name="password" {{ isset($edit) ? '' : 'required' }} class="w-full rounded-lg border-slate-300"></div>
    <div><label class="block text-sm mb-1">Confirmar contraseña</label><input type="password" name="password_confirmation" class="w-full rounded-lg border-slate-300"></div>
</div>
