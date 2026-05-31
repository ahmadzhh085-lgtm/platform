<?php

namespace Database\Factories;

use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    protected $model = Investment::class;

    public function definition(): array
    {
        return [
            'investor_id' => Investor::factory(),
            'project_id' => Project::factory(),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
