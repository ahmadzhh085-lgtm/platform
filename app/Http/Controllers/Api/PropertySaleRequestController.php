<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertySaleRequestStoreRequest;
use App\Http\Requests\UpdatePropertySaleRequestStatusRequest;
use App\Http\Resources\PropertySaleRequestResource;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertySaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PropertySaleRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertySaleRequest::query()->with(['user', 'project']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        return PropertySaleRequestResource::collection(
            $query->latest()->paginate($request->get('per_page', 15))
        );
    }

    public function show(PropertySaleRequest $propertySaleRequest)
    {
        $propertySaleRequest->load(['user', 'project', 'reviewer']);

        return new PropertySaleRequestResource($propertySaleRequest);
    }

    public function store(PropertySaleRequestStoreRequest $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        try {
            $propertySaleRequest = PropertySaleRequest::create($data);
        } catch (Throwable $e) {
            Log::error('Failed to create property sale request: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data,
            ]);

            return response()->json(['message' => 'Failed to create property sale request.'], 500);
        }

        return (new PropertySaleRequestResource($propertySaleRequest->load(['user'])))
            ->response()
            ->setStatusCode(201);
    }

    public function updateStatus(UpdatePropertySaleRequestStatusRequest $request, PropertySaleRequest $propertySaleRequest)
    {
        $propertySaleRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? null,
            'reviewed_by' => $request->user()?->id,
            'reviewed_at' => now(),
        ]);

        if ($request->status === 'approved') {
            $project = Project::query()
                ->where('name', $propertySaleRequest->title)
                ->where('city', $propertySaleRequest->city)
                ->first();

            if (! $project) {
                $project = Project::create([
                    'name' => $propertySaleRequest->title,
                    'type' => $propertySaleRequest->type,
                    'city' => $propertySaleRequest->city,
                    'description' => $propertySaleRequest->description,
                    'location' => $propertySaleRequest->location,
                    'status' => 'active',
                    'total_budget' => (float) $propertySaleRequest->price,
                ]);
            } else {
                $project->update([
                    'type' => $propertySaleRequest->type,
                    'description' => $propertySaleRequest->description,
                    'location' => $propertySaleRequest->location,
                    'status' => 'active',
                    'total_budget' => max((float) $project->total_budget, (float) $propertySaleRequest->price),
                ]);
            }

            Property::query()->firstOrCreate(
                [
                    'project_id' => $project->id,
                    'title' => $propertySaleRequest->title,
                ],
                [
                    'type' => $propertySaleRequest->type,
                    'price' => (float) $propertySaleRequest->price,
                    'city' => $propertySaleRequest->city,
                    'location' => $propertySaleRequest->location,
                    'area' => $propertySaleRequest->area,
                    'bedrooms' => $propertySaleRequest->bedrooms,
                    'status' => 'available',
                    'description' => $propertySaleRequest->description,
                ]
            );

            $propertySaleRequest->update([
                'project_id' => $project->id,
            ]);
        }

        return new PropertySaleRequestResource($propertySaleRequest->fresh()->load(['user', 'project', 'reviewer']));
    }
}
