<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planning = 'planificacion';
    case InProgress = 'en_proceso';
    case Paused = 'pausado';
    case Finished = 'finalizado';
    case Cancelled = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Planificación',
            self::InProgress => 'En proceso',
            self::Paused => 'Pausado',
            self::Finished => 'Finalizado',
            self::Cancelled => 'Cancelado',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn (self $status) => [$status->value => $status->label()]
        )->all();
    }
}
