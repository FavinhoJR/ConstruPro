<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        Gate::authorize('manage-inventory');

        $materials = Material::orderBy('name')->paginate(15);

        return view('materials.index', compact('materials'));
    }

    public function create(): View
    {
        Gate::authorize('manage-inventory');

        return view('materials.create');
    }

    public function store(StoreMaterialRequest $request): RedirectResponse
    {
        Material::create($request->validated());

        return redirect()->route('materials.index')->with('success', 'Material creado.');
    }

    public function edit(Material $material): View
    {
        Gate::authorize('manage-inventory');

        return view('materials.edit', compact('material'));
    }

    public function update(UpdateMaterialRequest $request, Material $material): RedirectResponse
    {
        $material->update($request->validated());

        return redirect()->route('materials.index')->with('success', 'Material actualizado.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        Gate::authorize('manage-inventory');
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material eliminado.');
    }
}
