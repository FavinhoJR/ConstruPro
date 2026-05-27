@extends('layouts.app')

@section('title', 'Personalizaci&oacute;n')

@section('content')
<div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6">
    <form method="POST" action="{{ route('settings.branding.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Nombre de la empresa</label>
                <input type="text" name="company_name" value="{{ old('company_name', $brandingSettings['company_name']) }}" required class="w-full rounded-lg border-slate-300">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Subt&iacute;tulo</label>
                <input type="text" name="tagline" value="{{ old('tagline', $brandingSettings['tagline']) }}" class="w-full rounded-lg border-slate-300">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Logo</label>
                <input type="file" name="logo" accept=".jpg,.jpeg,.png,.svg,.webp" class="w-full rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
                <p class="mt-2 text-xs text-slate-500">Formatos permitidos: JPG, PNG, SVG o WEBP. M&aacute;ximo 4 MB.</p>
            </div>
        </div>

        @if ($brandingSettings['logo_url'])
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="mb-3 text-sm font-medium text-slate-700">Logo actual</p>
                <div class="flex items-center gap-4">
                    <img src="{{ $brandingSettings['logo_url'] }}" alt="{{ $brandingSettings['company_name'] }}" class="h-16 w-16 rounded-xl border border-slate-200 bg-white object-contain p-2">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-slate-300">
                        Quitar logo actual
                    </label>
                </div>
            </div>
        @endif

        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
            <p>{{ $brandingSettings['footer_rights'] }}</p>
            <p>{{ $brandingSettings['footer_credit'] }}</p>
        </div>

        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-white">Guardar cambios</button>
    </form>
</div>
@endsection
