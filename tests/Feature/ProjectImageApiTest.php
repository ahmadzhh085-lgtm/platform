<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectImageApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_accepts_image_in_fillable_and_response(): void
    {
        $project = Project::create([
            'name' => 'Test Project',
            'description' => 'Example project description',
            'location' => 'Riyadh',
            'status' => 'active',
            'total_budget' => 100000,
            'image' => 'https://example.com/project.jpg',
        ]);

        $this->assertSame('https://example.com/project.jpg', $project->image);

        $response = $this->getJson('/api/projects');

        $response->assertOk();
        $response->assertJsonFragment([
            'name' => 'Test Project',
            'image' => 'https://example.com/project.jpg',
        ]);
    }
}
