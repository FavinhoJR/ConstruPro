<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'client' => fake()->company(),
            'description' => fake()->paragraph(),
            'location' => fake()->address(),
            'start_date' => now()->subDays(10),
            'estimated_end_date' => now()->addMonths(6),
            'status' => ProjectStatus::Planning,
            'estimated_budget' => fake()->randomFloat(2, 50000, 5000000),
            'responsible_id' => User::factory(),
        ];
    }
}
