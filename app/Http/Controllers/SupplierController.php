<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        Gate::authorize('manage-suppliers');

        $suppliers = Supplier::latest()->paginate(15);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        Gate::authorize('manage-suppliers');

        return view('suppliers.create');
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Proveedor creado.');
    }

    public function edit(Supplier $supplier): View
    {
        Gate::authorize('manage-suppliers');

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        Gate::authorize('manage-suppliers');
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado.');
    }
}
