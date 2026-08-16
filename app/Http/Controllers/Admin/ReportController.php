<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue = Investment::sum('amount');
        $activeProjects = Project::where('status', 'active')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingRequests = ProjectPurchaseRequest::where('status', 'pending')->count();
        $approvedRequests = ProjectPurchaseRequest::where('status', 'approved')->count();
        $rejectedRequests = ProjectPurchaseRequest::where('status', 'rejected')->count();

        $monthlyReports = ProjectPurchaseRequest::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(6)
            ->get();

        $projectsByStatus = Project::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'activeProjects',
            'totalUsers',
            'activeUsers',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'monthlyReports',
            'projectsByStatus'
        ));
    }
}
