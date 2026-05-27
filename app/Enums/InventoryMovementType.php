<?php

namespace App\Enums;

enum InventoryMovementType: string
{
    case In = 'entrada';
    case Out = 'salida';
    case Adjustment = 'ajuste';

    public function label(): string
    {
        return match ($this) {
            self::In => 'Entrada',
            self::Out => 'Salida',
            self::Adjustment => 'Ajuste',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn (self $type) => [$type->value => $type->label()]
        )->all();
    }
}
