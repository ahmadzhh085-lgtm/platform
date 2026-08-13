<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequestStoreRequest;
use App\Http\Requests\UpdatePurchaseRequestStatusRequest;
use App\Http\Resources\ProjectPurchaseRequestResource;
use App\Models\ProjectPurchaseRequest;
use Illuminate\Http\Request;

class ProjectPurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectPurchaseRequest::query()->with(['project', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        return ProjectPurchaseRequestResource::collection(
            $query->latest()->paginate($request->get('per_page', 15))
        );
    }

    public function show(ProjectPurchaseRequest $projectPurchaseRequest)
    {
        $projectPurchaseRequest->load(['project', 'user', 'reviewer']);

        return new ProjectPurchaseRequestResource($projectPurchaseRequest);
    }

    public function store(PurchaseRequestStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()?->id;
        $data['status'] = 'pending';

        $purchaseRequest = ProjectPurchaseRequest::create($data);

        return (new ProjectPurchaseRequestResource($purchaseRequest->load(['project', 'user'])))
            ->response()
            ->setStatusCode(201);
    }

    public function updateStatus(UpdatePurchaseRequestStatusRequest $request, ProjectPurchaseRequest $projectPurchaseRequest)
    {
        $projectPurchaseRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => $request->user()?->id,
            'reviewed_at' => now(),
        ]);

        return new ProjectPurchaseRequestResource($projectPurchaseRequest->fresh()->load(['project', 'user', 'reviewer']));
    }
}
