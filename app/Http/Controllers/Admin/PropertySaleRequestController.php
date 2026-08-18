<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertySaleRequest;
use Illuminate\Http\Request;

class PropertySaleRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertySaleRequest::query()->with(['user', 'project', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $propertySaleRequests = $query->latest()->paginate(15);
        $statuses = ['pending', 'approved', 'rejected'];
        $pendingCount = PropertySaleRequest::where('status', 'pending')->count();
        $approvedCount = PropertySaleRequest::where('status', 'approved')->count();
        $rejectedCount = PropertySaleRequest::where('status', 'rejected')->count();

        return view('admin.property-sale-requests.index', compact(
            'propertySaleRequests',
            'statuses',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function show(PropertySaleRequest $propertySaleRequest)
    {
        $propertySaleRequest->load(['user', 'project', 'reviewer']);

        return view('admin.property-sale-requests.show', compact('propertySaleRequest'));
    }

    public function approve(Request $request, PropertySaleRequest $propertySaleRequest)
    {
        $propertySaleRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

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

        return redirect()->route('admin.property-sale-requests.index')->with('success', 'تم الموافقة على طلب البيع بنجاح وإضافة العقار إلى قائمة العقارات.');
    }

    public function reject(Request $request, PropertySaleRequest $propertySaleRequest)
    {
        $propertySaleRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.property-sale-requests.index')->with('success', 'تم رفض طلب البيع بنجاح.');
    }
}
