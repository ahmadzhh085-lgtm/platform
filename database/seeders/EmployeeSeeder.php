<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'name' => 'موظف المالية',
                'email' => 'finance@admin.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
            [
                'name' => 'موظف الخدمات',
                'email' => 'service@admin.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ],
        ];
        foreach ($employees as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->assignRole('موظف المالية');
        }
    }
}
