@php($expense = $expense ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Proyecto</label>
        <select name="project_id" required class="w-full rounded-lg border-slate-300">
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $expense?->project_id) == $project->id)>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Categoría</label>
        <select name="expense_category_id" required class="w-full rounded-lg border-slate-300">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('expense_category_id', $expense?->expense_category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Descripción</label>
        <input type="text" name="description" value="{{ old('description', $expense?->description) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Monto</label>
        <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense?->amount) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Fecha</label>
        <input type="date" name="expense_date" value="{{ old('expense_date', optional($expense?->expense_date)->format('Y-m-d') ?? now()->toDateString()) }}" required class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Proveedor</label>
        <select name="supplier_id" class="w-full rounded-lg border-slate-300">
            <option value="">Opcional</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $expense?->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">N° factura</label>
        <input type="text" name="invoice_number" value="{{ old('invoice_number', $expense?->invoice_number) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Factura (foto/PDF)</label>
        <input type="file" name="invoice_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm">
    </div>
</div>
