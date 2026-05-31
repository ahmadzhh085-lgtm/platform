<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index(Request $request)
    {
        $query = Investor::query();
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%'.$request->search.'%');
        }
        $investors = $query->orderByDesc('id')->paginate(10);
        return view('admin.investors.index', compact('investors'));
    }

    public function create()
    {
        return view('admin.investors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'required|email|unique:investors,email',
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);
        Investor::create($data);
        return redirect()->route('admin.investors.index')->with('success', 'Investor created successfully.');
    }

    public function edit(Investor $investor)
    {
        return view('admin.investors.edit', compact('investor'));
    }

    public function update(Request $request, Investor $investor)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'required|email|unique:investors,email,'.$investor->id,
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);
        $investor->update($data);
        return redirect()->route('admin.investors.index')->with('success', 'Investor updated successfully.');
    }

    public function destroy(Investor $investor)
    {
        $investor->delete();
        return redirect()->route('admin.investors.index')->with('success', 'Investor deleted successfully.');
    }

    public function show(Investor $investor)
    {
        return view('admin.investors.show', compact('investor'));
    }
}
