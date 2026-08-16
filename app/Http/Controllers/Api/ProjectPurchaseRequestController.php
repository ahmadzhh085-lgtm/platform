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
        $user = $request->user();

        if (! $user) {
            Log::warning('Purchase request creation attempted without an authenticated user.');

            return response()->json([
                'message' => 'Unauthorized. Please login first.',
            ], 401);
        }

        $data = $request->validated();
        $amount = $request->input('offer_amount', $request->input('offer_price'));

        if ($amount === null || $amount === '') {
            return response()->json([
                'message' => 'The offer amount is required.',
            ], 422);
        }

        $data['offer_amount'] = (float) $amount;
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        unset($data['offer_price']);

        Log::info("Creating purchase request for user: {$user->id} with data: " . json_encode($data));

        try {
            $purchaseRequest = ProjectPurchaseRequest::create($data);

            if (! $purchaseRequest || ! $purchaseRequest->exists) {
                Log::error('Purchase request creation returned no persisted record.', [
                    'user_id' => $user->id,
                    'data' => $data,
                ]);

                return response()->json([
                    'message' => 'Failed to create purchase request. The record was not persisted.',
                ], 500);
            }

            Log::info("Purchase request created with ID: {$purchaseRequest->id}");
        } catch (Throwable $exception) {
            Log::error("Purchase request creation failed: {$exception->getMessage()}", [
                'user_id' => $user->id,
                'data' => $data,
                'exception' => $exception,
            ]);

            return response()->json([
                'message' => 'Failed to create purchase request.',
                'error' => $exception->getMessage(),
            ], 500);
        }

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

        if ($request->status === 'approved' && $projectPurchaseRequest->project_id) {
            $projectPurchaseRequest->project()->update(['status' => 'sold']);
        }

        return new ProjectPurchaseRequestResource($projectPurchaseRequest->fresh()->load(['project', 'user', 'reviewer']));
    }
}
