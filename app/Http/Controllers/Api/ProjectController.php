<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    // List projects (with pagination, search, filter)
    public function index(Request $request)
    {
        $projects = $this->service->list($request);
        return ProjectResource::collection($projects);
    }

    // Show single project
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    // Create project
    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $project = $this->service->create($request->validated());
        return new ProjectResource($project);
    }

    // Update project
    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project = $this->service->update($project, $request->validated());
        return new ProjectResource($project);
    }

    // Delete project
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $this->service->delete($project);
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
