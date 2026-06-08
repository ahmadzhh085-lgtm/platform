<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'investor_id' => 'required|integer|exists:investors,id',
            'property_id' => 'required|integer|exists:properties,id',
            'amount' => 'required|numeric|min:0.01',
            'expected_profit' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
            'payment_date' => 'nullable|date',
        ];
    }
}
