<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected PropertyService $service;

    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $properties = $this->service->list($request);
        return PropertyResource::collection($properties);
    }

    public function show(Property $property)
    {
        $property->load('project');
        return new PropertyResource($property);
    }

    public function store(PropertyRequest $request)
    {
        $property = $this->service->create($request->validated());
        return new PropertyResource($property->load('project'));
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $property = $this->service->update($property, $request->validated());
        return new PropertyResource($property->load('project'));
    }

    public function destroy(Property $property)
    {
        $this->service->delete($property);
        return response()->json(['message' => 'Property deleted successfully.']);
    }
}
