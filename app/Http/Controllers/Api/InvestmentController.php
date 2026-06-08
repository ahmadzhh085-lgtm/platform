<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Http\Resources\InvestmentResource;
use App\Models\Investment;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    protected InvestmentService $service;

    public function __construct(InvestmentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $investments = $this->service->list($request);
        return InvestmentResource::collection($investments);
    }

    public function show(Investment $investment)
    {
        $investment->load(['investor', 'property']);
        return new InvestmentResource($investment);
    }

    public function store(InvestmentRequest $request)
    {
        $investment = $this->service->create($request->validated());
        return new InvestmentResource($investment->load(['investor', 'property']));
    }

    public function update(InvestmentRequest $request, Investment $investment)
    {
        $investment = $this->service->update($investment, $request->validated());
        return new InvestmentResource($investment->load(['investor', 'property']));
    }

    public function destroy(Investment $investment)
    {
        $this->service->delete($investment);
        return response()->json(['message' => 'Investment deleted successfully.']);
    }
}
