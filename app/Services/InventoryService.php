<?php

namespace App\Services;

use App\Enums\InventoryMovementType;
use App\Models\InventoryMovement;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InventoryService
{
    public function applyMovement(
        Material $material,
        InventoryMovementType $type,
        float $quantity,
        int $userId,
        ?int $projectId = null,
        ?int $purchaseId = null,
        ?string $notes = null,
        ?string $movementDate = null,
        ?float $unitCost = null,
    ): InventoryMovement {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('La cantidad debe ser mayor a cero.');
        }

        return DB::transaction(function () use (
            $material, $type, $quantity, $userId, $projectId, $purchaseId, $notes, $movementDate, $unitCost
        ) {
            $locked = Material::query()->lockForUpdate()->findOrFail($material->id);
            $stock = (float) $locked->current_stock;
            $avgCost = (float) $locked->average_cost;

            $newStock = match ($type) {
                InventoryMovementType::In => $stock + $quantity,
                InventoryMovementType::Out => $stock - $quantity,
                InventoryMovementType::Adjustment => $quantity,
            };

            if ($type === InventoryMovementType::Out && $newStock < 0) {
                throw new InvalidArgumentException('Stock insuficiente para esta salida.');
            }

            if ($type === InventoryMovementType::In) {
                $incomingCost = $unitCost ?? $avgCost;
                $totalValue = ($stock * $avgCost) + ($quantity * $incomingCost);
                $locked->average_cost = $newStock > 0 ? $totalValue / $newStock : $incomingCost;
            }

            $locked->current_stock = $newStock;
            $locked->save();

            return InventoryMovement::create([
                'material_id' => $locked->id,
                'type' => $type,
                'quantity' => $quantity,
                'project_id' => $projectId,
                'purchase_id' => $purchaseId,
                'user_id' => $userId,
                'movement_date' => $movementDate ?? now()->toDateString(),
                'notes' => $notes,
            ]);
        });
    }
}
