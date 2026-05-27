<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', RoleName::Admin->value)->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@construpro.local'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Administrador',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'gerente@construpro.local'],
            [
                'role_id' => Role::where('name', RoleName::Manager->value)->value('id'),
                'name' => 'Gerente General',
                'password' => 'password',
                'is_active' => true,
            ]
        );
    }
}
