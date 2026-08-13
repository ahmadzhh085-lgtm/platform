<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectPurchaseRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_create_purchase_request_for_project(): void
    {
        $project = Project::create([
            'name' => 'مشروع جديد',
            'description' => 'وصف المشروع',
            'location' => 'الرياض',
            'status' => 'active',
            'total_budget' => 500000,
        ]);

        $response = $this->postJson('/api/project-purchase-requests', [
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
            'offer_price' => 580000,
            'status' => 'pending',
            'notes' => 'طلب شراء',
        ]);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

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
