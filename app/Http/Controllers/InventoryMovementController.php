<?php

namespace App\Http\Controllers;

use App\Enums\InventoryMovementType;
use App\Http\Requests\StoreInventoryMovementRequest;
use App\Models\InventoryMovement;
use App\Models\Material;
use App\Models\Project;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class InventoryMovementController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function index(): View
    {
        Gate::authorize('manage-inventory');

        $movements = InventoryMovement::with(['material', 'project', 'user'])
            ->latest()
            ->paginate(20);

        return view('inventory.index', [
            'movements' => $movements,
            'types' => InventoryMovementType::options(),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('manage-inventory');

        return view('inventory.create', [
            'materials' => Material::where('is_active', true)->orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get(),
            'types' => InventoryMovementType::options(),
        ]);
    }

    public function store(StoreInventoryMovementRequest $request): RedirectResponse
    {
        $material = Material::findOrFail($request->material_id);

        $this->inventoryService->applyMovement(
            material: $material,
            type: InventoryMovementType::from($request->type),
            quantity: (float) $request->quantity,
            userId: $request->user()->id,
            projectId: $request->project_id,
            notes: $request->notes,
            movementDate: $request->movement_date,
        );

        return redirect()->route('inventory.index')->with('success', 'Movimiento registrado.');
    }
}
