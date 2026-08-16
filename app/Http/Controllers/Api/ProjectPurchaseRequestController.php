<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequestStoreRequest;
use App\Http\Requests\UpdatePurchaseRequestStatusRequest;
use App\Http\Resources\ProjectPurchaseRequestResource;
use App\Models\ProjectPurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectPurchaseRequestController extends Controller
{
    /**
     * List purchase requests with optional filters.
     */
    public function index(Request $request)
    {
        $query = ProjectPurchaseRequest::with(['project', 'user']);

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

    /**
     * Show a single purchase request.
     */
    public function show(ProjectPurchaseRequest $projectPurchaseRequest)
    {
        $projectPurchaseRequest->load(['project', 'user', 'reviewer']);

        return new ProjectPurchaseRequestResource($projectPurchaseRequest);
    }

    /**
     * Store a new purchase request. Requires authenticated user (sanctum).
     */
    public function store(PurchaseRequestStoreRequest $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $data = $request->validated();

        // Support both offer_amount and legacy offer_price fields.
        $amount = $request->input('offer_amount', $request->input('offer_price'));

        if ($amount === null || $amount === '') {
            return response()->json(['message' => 'The offer amount is required.'], 422);
        }

        $data['offer_amount'] = (float) $amount;
        $data['user_id'] = $user->id;
        $data['status'] = $data['status'] ?? 'pending';

        try {
            $purchaseRequest = ProjectPurchaseRequest::create($data);
        } catch (Throwable $e) {
            Log::error('Failed to create purchase request: ' . $e->getMessage(), ['exception' => $e, 'data' => $data]);
            return response()->json(['message' => 'Failed to create purchase request.'], 500);
        }

        return (new ProjectPurchaseRequestResource($purchaseRequest->load(['project', 'user'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update status (approve/reject) for an existing purchase request.
     */
    public function updateStatus(UpdatePurchaseRequestStatusRequest $request, ProjectPurchaseRequest $projectPurchaseRequest)
    {
        $projectPurchaseRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? null,
            'reviewed_by' => $request->user()?->id,
            'reviewed_at' => now(),
        ]);

        if ($request->status === 'approved' && $projectPurchaseRequest->project_id) {
            $projectPurchaseRequest->project()->update(['status' => 'sold']);
        }

        return new ProjectPurchaseRequestResource($projectPurchaseRequest->fresh()->load(['project', 'user', 'reviewer']));
    }
}

