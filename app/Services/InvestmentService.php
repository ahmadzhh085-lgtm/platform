<?php

namespace App\Services;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentService
{
    public function list(Request $request)
    {
        return Investment::with(['investor', 'property'])
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('investor_id'), function ($query, $investorId) {
                $query->where('investor_id', $investorId);
            })
            ->when($request->query('property_id'), function ($query, $propertyId) {
                $query->where('property_id', $propertyId);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('investor', function ($query) use ($search) {
                        $query->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('property', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(15);
    }

    public function create(array $data): Investment
    {
        return Investment::create($data);
    }

    public function update(Investment $investment, array $data): Investment
    {
        $investment->update($data);
        return $investment;
    }

    public function delete(Investment $investment): void
    {
        $investment->delete();
    }
}
