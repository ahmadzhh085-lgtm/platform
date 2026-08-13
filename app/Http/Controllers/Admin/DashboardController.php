<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectPurchaseRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $purchaseRequests = ProjectPurchaseRequest::with(['project', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $pendingPurchaseRequests = ProjectPurchaseRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact('purchaseRequests', 'pendingPurchaseRequests'));
    }
}
