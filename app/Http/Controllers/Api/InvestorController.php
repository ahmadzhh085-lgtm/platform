<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestorRequest;
use App\Http\Resources\InvestorResource;
use App\Models\Investor;
use App\Services\InvestorService;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    protected InvestorService $service;

    public function __construct(InvestorService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $investors = $this->service->list($request);
        return InvestorResource::collection($investors);
    }

    public function show(Investor $investor)
    {
        $investor->load('investments');
        return new InvestorResource($investor);
    }

    public function store(InvestorRequest $request)
    {
        $investor = $this->service->create($request->validated());
        return new InvestorResource($investor);
    }

    public function update(InvestorRequest $request, Investor $investor)
    {
        $investor = $this->service->update($investor, $request->validated());
        return new InvestorResource($investor);
    }

    public function destroy(Investor $investor)
    {
        $this->service->delete($investor);
        return response()->json(['message' => 'Investor deleted successfully.']);
    }
}
