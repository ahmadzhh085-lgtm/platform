<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Project;
use App\Services\CloudinaryService;
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
            try {
                \Log::info('Starting image upload', ['file' => $request->file('image')->getClientOriginalName()]);
                $cloudinary = new CloudinaryService();
                $data['image'] = $cloudinary->upload($request->file('image'));
                \Log::info('Image uploaded successfully', ['url' => $data['image']]);
            } catch (\Exception $e) {
                \Log::error('Image upload failed in store', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ خطأ في رفع الصورة: ' . $e->getMessage());
            }
        }
        
        Property::create($data);
        return redirect()->route('admin.properties.index')->with('success', '✅ تم إنشاء المنتج بنجاح.');
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
            try {
                \Log::info('Starting image update', ['file' => $request->file('image')->getClientOriginalName()]);
                
                // حذف الصورة القديمة من Cloudinary
                if ($property->image) {
                    $cloudinary = new CloudinaryService();
                    $cloudinary->delete($property->image);
                }
                
                // رفع الصورة الجديدة
                $cloudinary = new CloudinaryService();
                $data['image'] = $cloudinary->upload($request->file('image'));
                
                \Log::info('Image updated successfully', ['url' => $data['image']]);
            } catch (\Exception $e) {
                \Log::error('Image update failed', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ خطأ في رفع الصورة: ' . $e->getMessage());
            }
        }
        
        $property->update($data);
        return redirect()->route('admin.properties.index')->with('success', '✅ تم تحديث المنتج بنجاح.');
    }

    public function destroy(Property $property)
    {
        // حذف الصورة من Cloudinary
        if ($property->image) {
            try {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($property->image);
            } catch (\Exception $e) {
                \Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
            }
        }
        
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', '✅ تم حذف المنتج بنجاح.');
    }

    public function show(Property $property)
    {
        return view('admin.properties.show', compact('property'));
    }
}
