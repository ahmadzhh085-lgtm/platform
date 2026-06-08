<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Investor;
use App\Models\Property;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['investor', 'property'])->paginate(10);

        return view('admin.investments.index', compact('investments'));
    }

    public function create()
    {
        $investors = Investor::orderBy('name')->get();
        $properties = Property::orderBy('title')->get();

        return view('admin.investments.create', compact('investors', 'properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'investor_id' => ['required', 'exists:investors,id'],
            'property_id' => ['required', 'exists:properties,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expected_profit' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'payment_date' => ['nullable', 'date'],
        ]);

        Investment::create($data);

        return redirect()->route('admin.investments.index')->with('success', 'تم إضافة الاستثمار بنجاح.');
    }

    public function show(Investment $investment)
    {
        $investment->load(['investor', 'property']);

        return view('admin.investments.show', compact('investment'));
    }

    public function edit(Investment $investment)
    {
        $investors = Investor::orderBy('name')->get();
        $properties = Property::orderBy('title')->get();

        return view('admin.investments.edit', compact('investment', 'investors', 'properties'));
    }

    public function update(Request $request, Investment $investment)
    {
        $data = $request->validate([
            'investor_id' => ['required', 'exists:investors,id'],
            'property_id' => ['required', 'exists:properties,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expected_profit' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'payment_date' => ['nullable', 'date'],
        ]);

        $investment->update($data);

        return redirect()->route('admin.investments.index')->with('success', 'تم تحديث الاستثمار بنجاح.');
    }

    public function destroy(Investment $investment)
    {
        $investment->delete();

        return redirect()->route('admin.investments.index')->with('success', 'تم حذف الاستثمار بنجاح.');
    }
}
