<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        $investors = Investor::all();
        $projects = Project::all();
        if ($investors->count() && $projects->count()) {
            foreach ($investors as $investor) {
                Investment::create([
                    'investor_id' => $investor->id,
                    'project_id' => $projects->random()->id,
                    'amount' => rand(10000, 100000),
                    'status' => 'approved',
                ]);
            }
        }
    }
}
