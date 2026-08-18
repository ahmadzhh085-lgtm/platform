<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectPurchaseRequest;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectPurchaseRequest::query()->with(['project', 'user', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $purchaseRequests = $query->latest()->paginate(15);
        $statuses = ['pending', 'approved', 'rejected'];
        $pendingCount = ProjectPurchaseRequest::where('status', 'pending')->count();
        $approvedCount = ProjectPurchaseRequest::where('status', 'approved')->count();
        $rejectedCount = ProjectPurchaseRequest::where('status', 'rejected')->count();

        return view('admin.purchase-requests.index', compact('purchaseRequests', 'statuses', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function show(ProjectPurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load(['project', 'user', 'reviewer']);

        return view('admin.purchase-requests.show', compact('purchaseRequest'));
    }

    public function update(Request $request, ProjectPurchaseRequest $purchaseRequest)
    {
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $purchaseRequest->update([
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        if ($data['status'] === 'approved' && $purchaseRequest->project_id) {
            $purchaseRequest->project()->update(['status' => 'sold']);
        }

        return redirect()->route('admin.purchase-requests.index')->with('success', 'تم تحديث حالة طلب الشراء بنجاح.');
    }

    public function approve(Request $request, ProjectPurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        if ($purchaseRequest->project_id) {
            $purchaseRequest->project()->update(['status' => 'sold']);
        }

        return redirect()->route('admin.purchase-requests.index')->with('success', 'تم الموافقة على طلب الشراء بنجاح.');
    }

    public function reject(Request $request, ProjectPurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(), 
        ]);

        return redirect()->route('admin.purchase-requests.index')->with('success', 'تم رفض طلب الشراء بنجاح.');
    }
    
}
