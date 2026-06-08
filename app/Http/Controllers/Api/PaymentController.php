<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $payments = $this->service->list($request);
        return PaymentResource::collection($payments);
    }

    public function show(Payment $payment)
    {
        $payment->load('investment');
        return new PaymentResource($payment);
    }

    public function store(PaymentRequest $request)
    {
        $payment = $this->service->create($request->validated());
        return new PaymentResource($payment->load('investment'));
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment = $this->service->update($payment, $request->validated());
        return new PaymentResource($payment->load('investment'));
    }

    public function destroy(Payment $payment)
    {
        $this->service->delete($payment);
        return response()->json(['message' => 'Payment deleted successfully.']);
    }
}
