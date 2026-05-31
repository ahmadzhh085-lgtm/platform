<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       //view all investments and properties in the dashboard
        return view('admin.dashboard');
    }
}
