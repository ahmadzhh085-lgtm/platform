<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectPurchaseRequestFactory extends Factory
{
    protected $model = ProjectPurchaseRequest::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'buyer_name' => $this->faker->name(),
            'buyer_phone' => $this->faker->phoneNumber(),
            'buyer_email' => $this->faker->safeEmail(),
            'buyer_national_id' => $this->faker->numerify('##########'),
            'offer_amount' => $this->faker->randomFloat(2, 1000, 500000),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
