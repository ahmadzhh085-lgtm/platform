<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseRequestApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_purchase_request_and_admin_can_approve_it(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'name' => 'Villas Tower',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user, 'web')
            ->postJson('/api/purchase-requests', [
                'project_id' => $project->id,
                'buyer_name' => 'Ahmed Ali',
                'buyer_phone' => '966500000000',
                'buyer_email' => 'ahmed@example.com',
                'buyer_national_id' => '1234567890',
                'offer_amount' => 250000,
                'notes' => 'أرغب في شراء المشروع فورًا.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.buyer_name', 'Ahmed Ali')
            ->assertJsonPath('data.status', 'pending');

        $purchaseRequest = \App\Models\ProjectPurchaseRequest::first();

        $this->assertNotNull($purchaseRequest);
        $this->assertEquals('pending', $purchaseRequest->status);

        $decisionResponse = $this->actingAs($user, 'web')
            ->patchJson('/api/purchase-requests/' . $purchaseRequest->id . '/status', [
                'status' => 'approved',
                'admin_notes' => 'تمت الموافقة',
            ]);

        $decisionResponse->assertStatus(200)
            ->assertJsonPath('data.status', 'approved')
            ->assertJsonPath('data.admin_notes', 'تمت الموافقة');

        $this->assertDatabaseHas('project_purchase_requests', [
            'id' => $purchaseRequest->id,
            'status' => 'approved',
        ]);
    }
}
