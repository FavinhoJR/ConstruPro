<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Materiales',
            'Mano de obra',
            'Subcontratos',
            'Transporte',
            'Equipos',
            'Administrativos',
            'Otros',
        ];

        foreach ($categories as $name) {
            ExpenseCategory::updateOrCreate(['name' => $name]);
        }
    }
}
