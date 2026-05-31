<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = \App\Models\Investment::paginate(10);
        return view('admin.investments.index', compact('investments'));
    }
}
