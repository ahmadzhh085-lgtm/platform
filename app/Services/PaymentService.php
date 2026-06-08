<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentService
{
    public function list(Request $request)
    {
        return Payment::with('investment')
            ->when($request->query('investment_id'), function ($query, $investmentId) {
                $query->where('investment_id', $investmentId);
            })
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate($request->query('per_page', 15));
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function update(Payment $payment, array $data)
    {
        $payment->update($data);
        return $payment;
    }

    public function delete(Payment $payment)
    {
        $payment->delete();
    }
}
