<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDashboardAndRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_real_statistics(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Employee']);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $project = Project::factory()->create(['status' => 'active', 'total_budget' => 150000]);
        $investor = Investor::factory()->create();
        Investment::factory()->create([
            'investor_id' => $investor->id,
            'amount' => 25000,
            'status' => 'paid',
        ]);
        ProjectPurchaseRequest::factory()->create([
            'project_id' => $project->id,
            'user_id' => $admin->id,
            'status' => 'pending',
            'offer_amount' => 6000,
        ]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('25000')
            ->assertSee('1')
            ->assertSee('1')
            ->assertSee('Analytics Summary');
    }

    public function test_admin_can_change_user_role(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Employee']);
        Role::firstOrCreate(['name' => 'User']);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user = User::factory()->create(['name' => 'Test User']);

        $this->actingAs($admin)
            ->put(route('admin.employees.update', $user), [
                'name' => 'Test User',
                'email' => $user->email,
                'status' => 'active',
                'roles' => ['Employee'],
                'permissions' => [],
            ])
            ->assertRedirect(route('admin.employees.index'));

        $this->assertTrue($user->fresh()->hasRole('Employee'));
    }
}
