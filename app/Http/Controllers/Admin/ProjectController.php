<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\Admin\ProjectRequest;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        
        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        
        $projects = $query->orderByDesc('id')->paginate(10);
        $statuses = Project::distinct()->pluck('status'); // Get all statuses
        return view('admin.projects.index', compact('projects', 'statuses'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            try {
                $cloudinary = new CloudinaryService();
                $data['image'] = $cloudinary->upload($request->file('image'));
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', '❌ خطأ في رفع صورة المشروع: ' . $e->getMessage());
            }
        }

        $project = Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            try {
                if ($project->image) {
                    $cloudinary = new CloudinaryService();
                    $cloudinary->delete($project->image);
                }

                $cloudinary = new CloudinaryService();
                $data['image'] = $cloudinary->upload($request->file('image'));
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', '❌ خطأ في تحديث صورة المشروع: ' . $e->getMessage());
            }
        }

        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            try {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($project->image);
            } catch (\Exception $e) {
                \Log::warning('Failed to delete project image from Cloudinary: ' . $e->getMessage());
            }
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }
}
