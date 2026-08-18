<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;
use App\Models\ProjectPurchaseRequest;
use App\Models\PropertySaleRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $purchaseRequests = ProjectPurchaseRequest::with(['project', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $propertySaleRequests = PropertySaleRequest::with(['user', 'project'])
            ->latest()
            ->limit(5)
            ->get();

        $pendingPurchaseRequests = ProjectPurchaseRequest::where('status', 'pending')->count();
        $pendingPropertySaleRequests = PropertySaleRequest::where('status', 'pending')->count();
        $totalInvestments = (float) Investment::sum('amount');
        $totalInvestors = Investor::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Admin', 'Super Admin']);
        })->count();
        $recentUsers = User::with('roles')->latest()->limit(6)->get();

        return view('admin.dashboard', compact(
            'purchaseRequests',
            'propertySaleRequests',
            'pendingPurchaseRequests',
            'pendingPropertySaleRequests',
            'totalInvestments',
            'totalInvestors',
            'activeProjects',
            'totalUsers',
            'activeUsers',
            'adminUsers',
            'recentUsers'
        ));
    }
}
