<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3">Descripción</th>
                <th class="px-4 py-3">Categoría</th>
                <th class="px-4 py-3">Monto</th>
                <th class="px-4 py-3">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $expense->description }}</td>
                    <td class="px-4 py-3">{{ $expense->category->name }}</td>
                    <td class="px-4 py-3">Q {{ number_format($expense->amount, 2) }}</td>
                    <td class="px-4 py-3"><x-badge :text="$expense->status->label()" /></td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Sin gastos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
