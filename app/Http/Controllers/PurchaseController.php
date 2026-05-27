<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseStatus;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Material;
use App\Models\Project;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\DocumentStorageService;
use App\Services\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function __construct(
        private readonly DocumentStorageService $documents,
        private readonly PurchaseService $purchaseService,
    ) {}

    public function index(): View
    {
        Gate::authorize('manage-purchases');

        $purchases = Purchase::with(['supplier', 'project'])->latest()->paginate(15);

        return view('purchases.index', compact('purchases'));
    }

    public function create(): View
    {
        Gate::authorize('manage-purchases');

        return view('purchases.create', [
            'suppliers' => Supplier::orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get(),
            'materials' => Material::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        $purchase = DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'project_id' => $request->project_id,
                'purchase_date' => $request->purchase_date,
                'status' => PurchaseStatus::Pending,
                'created_by' => $request->user()->id,
                'total' => 0,
            ]);

            foreach ($request->items as $item) {
                $subtotal = round($item['quantity'] * $item['unit_cost'], 2);
                $purchase->items()->create([
                    'material_id' => $item['material_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

            $purchase->recalculateTotal();

            return $purchase;
        });

        if ($request->hasFile('document')) {
            $this->documents->store(
                $request->file('document'),
                $purchase,
                $request->user()->id,
                'cotizacion',
                'purchases'
            );
        }

        return redirect()->route('purchases.show', $purchase)->with('success', 'Compra registrada.');
    }

    public function show(Purchase $purchase): View
    {
        Gate::authorize('manage-purchases');

        $purchase->load(['items.material', 'supplier', 'project', 'documents', 'creator']);

        return view('purchases.show', [
            'purchase' => $purchase,
            'statuses' => PurchaseStatus::options(),
        ]);
    }

    public function receive(Request $request, Purchase $purchase): RedirectResponse
    {
        Gate::authorize('manage-purchases');

        try {
            $this->purchaseService->markAsReceived($purchase, $request->user()->id);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['purchase' => $e->getMessage()]);
        }

        return redirect()->route('purchases.show', $purchase)->with('success', 'Compra recibida e inventario actualizado.');
    }

    public function cancel(Purchase $purchase): RedirectResponse
    {
        Gate::authorize('manage-purchases');

        if ($purchase->status === PurchaseStatus::Received) {
            return back()->withErrors(['purchase' => 'No se puede anular una compra ya recibida.']);
        }

        $purchase->update(['status' => PurchaseStatus::Cancelled]);

        return back()->with('success', 'Compra anulada.');
    }
}
