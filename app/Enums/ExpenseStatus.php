<?php

namespace App\Enums;

enum ExpenseStatus: string
{
    case Pending = 'pendiente';
    case Approved = 'aprobado';
    case Rejected = 'rechazado';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Approved => 'Aprobado',
            self::Rejected => 'Rechazado',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn (self $status) => [$status->value => $status->label()]
        )->all();
    }
}
