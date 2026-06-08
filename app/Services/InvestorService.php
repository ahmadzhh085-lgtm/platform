<?php

namespace App\Services;

use App\Models\Investor;
use Illuminate\Http\Request;

class InvestorService
{
    public function list(Request $request)
    {
        return Investor::withCount('investments')
            ->when($request->query('search'), function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($request->query('per_page', 15));
    }

    public function create(array $data)
    {
        return Investor::create($data);
    }

    public function update(Investor $investor, array $data)
    {
        $investor->update($data);
        return $investor;
    }

    public function delete(Investor $investor)
    {
        $investor->delete();
    }
}
