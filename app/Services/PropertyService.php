<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyService
{
    public function list(Request $request)
    {
        return Property::with('project')
            ->when($request->query('project_id'), function ($query, $projectId) {
                $query->where('project_id', $projectId);
            })
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->query('per_page', 15));
    }

    public function create(array $data)
    {
        return Property::create($data);
    }

    public function update(Property $property, array $data)
    {
        $property->update($data);
        return $property;
    }

    public function delete(Property $property)
    {
        $property->delete();
    }
}
