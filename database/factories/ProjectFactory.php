<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Project',
            'type' => $this->faker->randomElement(['villa', 'apartment', 'commercial']),
            'city' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'sold']),
            'total_budget' => $this->faker->randomFloat(2, 10000, 500000),
        ];
    }
}
