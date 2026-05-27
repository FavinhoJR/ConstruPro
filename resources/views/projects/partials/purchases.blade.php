<div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
    <div class="overflow-x-auto">
    <table class="min-w-[560px] w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3">Proveedor</th>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchases as $purchase)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $purchase->supplier->name }}</td>
                    <td class="px-4 py-3">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">Q {{ number_format($purchase->total, 2) }}</td>
                    <td class="px-4 py-3"><x-badge :text="$purchase->status->label()" /></td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Sin compras.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
