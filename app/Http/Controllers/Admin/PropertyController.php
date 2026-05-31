<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Project;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('project');
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        $properties = $query->orderByDesc('id')->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('admin.properties.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }
        Property::create($data);
        return redirect()->route('admin.properties.index')->with('success', 'Property created successfully.');
    }

    public function edit(Property $property)
    {
        $projects = Project::all();
        return view('admin.properties.edit', compact('property', 'projects'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }
        $property->update($data);
        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }

    public function show(Property $property)
    {
        return view('admin.properties.show', compact('property'));
    }
}
