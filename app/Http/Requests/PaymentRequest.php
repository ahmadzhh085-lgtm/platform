<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'investment_id' => 'required|integer|exists:investments,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string|max:100',
            'payment_date' => 'required|date',
            'status' => 'required|string|max:50',
        ];
    }
}
