<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Property;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        $investors = Investor::all();
        $properties = Property::all();

        if ($investors->count() && $properties->count()) {
            foreach ($investors as $investor) {
                Investment::create([
                    'investor_id' => $investor->id,
                    'property_id' => $properties->random()->id,
                    'amount' => rand(10000, 100000),
                    'status' => 'approved',
                ]);
            }
        }
    }
}
