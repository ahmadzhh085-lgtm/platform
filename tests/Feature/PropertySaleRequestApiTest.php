<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertySaleRequestApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_property_sale_request_and_admin_can_approve_it_into_projects(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'web')
            ->postJson('/api/property-sale-requests', [
                'seller_name' => 'أحمد السالم',
                'seller_phone' => '966500000001',
                'seller_email' => 'seller@example.com',
                'seller_national_id' => '1234567890',
                'title' => 'فيلا في الرياض',
                'type' => 'villa',
                'price' => 850000,
                'city' => 'الرياض',
                'location' => 'حي النخيل',
                'area' => 320,
                'bedrooms' => 4,
                'description' => 'فيلا حديثة بعرض رائع وموقع مميز.',
                'notes' => 'أرغب في بيع العقار فوراً.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'فيلا في الرياض')
            ->assertJsonPath('data.status', 'pending');

        $saleRequest = \App\Models\PropertySaleRequest::first();

        $this->assertNotNull($saleRequest);
        $this->assertEquals('pending', $saleRequest->status);

        $decisionResponse = $this->actingAs($user, 'web')
            ->patchJson('/api/property-sale-requests/' . $saleRequest->id . '/status', [
                'status' => 'approved',
                'admin_notes' => 'تمت الموافقة بناءً على بيانات العقار.',
            ]);

        $decisionResponse->assertStatus(200)
            ->assertJsonPath('data.status', 'approved')
            ->assertJsonPath('data.admin_notes', 'تمت الموافقة بناءً على بيانات العقار.');

        $this->assertDatabaseHas('property_sale_requests', [
            'id' => $saleRequest->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'فيلا في الرياض',
            'city' => 'الرياض',
            'status' => 'active',
        ]);

        $this->assertTrue(Project::where('name', 'فيلا في الرياض')->where('city', 'الرياض')->exists());
    }
}
