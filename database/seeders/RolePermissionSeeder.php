<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Employee',
            'Accountant',
            'موظف المالية',
            'موظف الخدمات',
        ];

        $permissions = [
            'manage properties',
            'manage projects',
            'manage investors',
            'manage investments',
            'manage payments',
            'manage employees',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $role) {
            $roleModel = Role::firstOrCreate(['name' => $role]);
            if ($role === 'Super Admin') {
                $roleModel->syncPermissions($permissions);
            } elseif ($role === 'Admin') {
                $roleModel->syncPermissions([
                    'manage properties',
                    'manage projects',
                    'manage investors',
                    'manage investments',
                    'manage payments',
                    'manage employees',
                    'view reports',
                ]);
            } elseif ($role === 'Employee' || $role === 'موظف الخدمات') {
                $roleModel->syncPermissions([
                    'manage properties',
                    'manage projects',
                    'manage investors',
                    'manage investments',
                    'manage payments',
                    'view reports',
                ]);
            } elseif ($role === 'Accountant' || $role === 'موظف المالية') {
                $roleModel->syncPermissions([
                    'manage payments',
                    'view reports',
                ]);
            }
        }
    }
}
