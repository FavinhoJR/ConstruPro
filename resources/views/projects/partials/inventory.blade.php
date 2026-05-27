<div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
    <table class="min-w-[560px] w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3">Material</th>
                <th class="px-4 py-3">Tipo</th>
                <th class="px-4 py-3">Cantidad</th>
                <th class="px-4 py-3">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movements as $movement)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $movement->material->name }}</td>
                    <td class="px-4 py-3">{{ $movement->type->label() }}</td>
                    <td class="px-4 py-3">{{ \App\Support\Format::quantity($movement->quantity) }}</td>
                    <td class="px-4 py-3">{{ $movement->movement_date->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Sin movimientos.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
