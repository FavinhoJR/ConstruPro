<?php

namespace App\Enums;

enum RoleName: string
{
    case Admin = 'admin';
    case Manager = 'gerente';
    case Supervisor = 'supervisor';
    case Warehouse = 'bodega';
    case Accounting = 'contabilidad';
    case User = 'usuario';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Manager => 'Gerente',
            self::Supervisor => 'Supervisor',
            self::Warehouse => 'Bodega',
            self::Accounting => 'Contabilidad',
            self::User => 'Usuario',
        };
    }
}
