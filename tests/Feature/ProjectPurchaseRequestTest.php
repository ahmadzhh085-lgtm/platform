<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProjectPurchaseRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_route_and_offer_price_field_can_still_create_purchase_request(): void
    {
        $project = Project::create([
            'name' => 'مشروع موروث',
            'description' => 'وصف المشروع',
            'location' => 'الدمام',
            'status' => 'active',
            'total_budget' => 700000,
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/project-purchase-requests', [
            'project_id' => $project->id,
            'buyer_name' => 'سارة legacy',
            'buyer_phone' => '0551234567',
            'buyer_email' => 'legacy@example.com',
            'buyer_national_id' => '1122334455',
            'offer_price' => '470000',
            'notes' => 'طلب شراء قديم',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.project_id', $project->id)
            ->assertJsonPath('data.offer_amount', '470000.00')
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('project_purchase_requests', [
            'project_id' => $project->id,
            'buyer_name' => 'سارة legacy',
            'offer_amount' => 470000.00,
            'status' => 'pending',
        ]);
    }

    public function test_buyer_can_create_purchase_request_for_project(): void
    {
        $project = Project::create([
            'name' => 'مشروع جديد',
            'description' => 'وصف المشروع',
            'location' => 'الرياض',
            'status' => 'active',
            'total_budget' => 500000,
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/project-purchase-requests', [
            'project_id' => $project->id,
            'buyer_name' => 'محمد علي',
            'buyer_phone' => '0501234567',
            'buyer_email' => 'buyer@example.com',
            'buyer_national_id' => '1234567890',
            'offer_price' => '470000',
            'notes' => 'أرغب في الشراء فوراً',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.project_id', $project->id)
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('project_purchase_requests', [
            'project_id' => $project->id,
            'buyer_name' => 'محمد علي',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_purchase_request_and_mark_project_sold(): void
    {
        $project = Project::create([
            'name' => 'مشروع للبيع',
            'description' => 'وصف',
            'location' => 'جدة',
            'status' => 'active',
            'total_budget' => 600000,
        ]);

        $request = ProjectPurchaseRequest::create([
            'project_id' => $project->id,
            'buyer_name' => 'سارة حسن',
            'buyer_phone' => '0551112233',
            'buyer_email' => 'sara@example.com',
            'buyer_national_id' => '0987654321',
            'offer_amount' => 580000,
            'status' => 'pending',
            'notes' => 'طلب شراء',
        ]);

        $admin = User::factory()->create();
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin, 'sanctum')->patchJson('/api/project-purchase-requests/' . $request->id . '/status', [
            'status' => 'approved',
            'admin_notes' => 'موافق عليه من الإدارة',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'approved')
            ->assertJsonPath('data.project.status', 'sold');

        $this->assertDatabaseHas('project_purchase_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);

        $this->assertSame('sold', $project->fresh()->status);
    }
}
