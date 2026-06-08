<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvestorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $investorId = $this->route('investor')?->id;

        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('investors')->ignore($investorId),
            ],
            'national_id' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ];
    }
}
