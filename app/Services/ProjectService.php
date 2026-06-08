<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectService
{
    public function list(Request $request)
    {
        $query = Project::query();
        
        // Search by name
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }
        
        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        
        // Filter by location
        if ($location = $request->input('location')) {
            $query->where('location', 'like', "%$location%");
        }
        
        // Pagination
        $perPage = $request->input('per_page', 15);
        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data)
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project)
    {
        $project->delete();
    }
}
