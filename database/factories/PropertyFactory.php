<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(3),
            'type' => $this->faker->randomElement(['villa', 'apartment', 'land', 'commercial']),
            'price' => $this->faker->randomFloat(2, 50000, 500000),
            'location' => $this->faker->city(),
            'area' => $this->faker->numberBetween(80, 500),
            'status' => $this->faker->randomElement(['available', 'sold', 'reserved']),
        ];
    }
}
