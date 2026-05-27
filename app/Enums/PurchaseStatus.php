<?php

namespace App\Enums;

enum PurchaseStatus: string
{
    case Pending = 'pendiente';
    case Received = 'recibida';
    case Cancelled = 'anulada';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Received => 'Recibida',
            self::Cancelled => 'Anulada',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn (self $status) => [$status->value => $status->label()]
        )->all();
    }
}
