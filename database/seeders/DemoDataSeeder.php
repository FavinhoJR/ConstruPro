<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Material;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $responsible = User::where('email', 'gerente@construpro.local')->first();

        Project::updateOrCreate(
            ['name' => 'Edificio Centro Comercial'],
            [
                'client' => 'Inversiones GT S.A.',
                'description' => 'Construcción de edificio comercial de 4 niveles.',
                'location' => 'Zona 10, Ciudad de Guatemala',
                'start_date' => now()->subMonths(2)->toDateString(),
                'estimated_end_date' => now()->addMonths(8)->toDateString(),
                'status' => ProjectStatus::InProgress,
                'estimated_budget' => 2500000,
                'responsible_id' => $responsible?->id,
            ]
        );

        Supplier::updateOrCreate(
            ['name' => 'Ferretería El Constructor'],
            [
                'tax_id' => '1234567-8',
                'phone' => '2222-3333',
                'email' => 'ventas@elconstructor.gt',
                'address' => 'Calzada Aguilar Batres 12-34',
                'primary_contact' => 'Carlos Méndez',
            ]
        );

        Material::updateOrCreate(
            ['code' => 'CEM-001'],
            [
                'name' => 'Cemento gris 50kg',
                'description' => 'Cemento Portland tipo I',
                'unit' => 'saco',
                'current_stock' => 120,
                'minimum_stock' => 50,
                'average_cost' => 85.50,
                'is_active' => true,
            ]
        );

        Material::updateOrCreate(
            ['code' => 'VAR-001'],
            [
                'name' => 'Varilla #4',
                'description' => 'Acero de refuerzo 1/2 pulgada',
                'unit' => 'unidad',
                'current_stock' => 15,
                'minimum_stock' => 30,
                'average_cost' => 45.00,
                'is_active' => true,
            ]
        );
    }
}
