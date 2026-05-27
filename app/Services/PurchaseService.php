<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Enums\PurchaseStatus;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PurchaseService
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function markAsReceived(Purchase $purchase, int $userId): Purchase
    {
        if ($purchase->status === PurchaseStatus::Received) {
            throw new InvalidArgumentException('La compra ya fue recibida.');
        }

        if ($purchase->status === PurchaseStatus::Cancelled) {
            throw new InvalidArgumentException('No se puede recibir una compra anulada.');
        }

        return DB::transaction(function () use ($purchase, $userId) {
            $purchase->load('items.material');

            foreach ($purchase->items as $item) {
                $this->inventoryService->applyMovement(
                    material: $item->material,
                    type: InventoryMovementType::In,
                    quantity: (float) $item->quantity,
                    userId: $userId,
                    projectId: $purchase->project_id,
                    purchaseId: $purchase->id,
                    notes: 'Entrada automática por compra #'.$purchase->id,
                    movementDate: $purchase->purchase_date->toDateString(),
                    unitCost: (float) $item->unit_cost,
                );
            }

            $purchase->update(['status' => PurchaseStatus::Received]);

            return $purchase->fresh(['items.material', 'supplier', 'project']);
        });
    }
}
