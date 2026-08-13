<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'buyer_name' => ['required', 'string', 'max:255'],
            'buyer_phone' => ['required', 'string', 'max:255'],
            'buyer_email' => ['required', 'email', 'max:255'],
            'buyer_national_id' => ['required', 'string', 'max:255'],
            'offer_amount' => ['nullable', 'numeric', 'min:0'],
            'offer_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $amount = $this->input('offer_amount', $this->input('offer_price'));

        if ($amount !== null && ! array_key_exists('offer_amount', $data)) {
            $data['offer_amount'] = $amount;
        }

        if ($amount !== null && ! array_key_exists('offer_price', $data)) {
            $data['offer_price'] = $amount;
        }

        if ($amount === null) {
            $data['offer_amount'] = null;
        }

        return $data;
    }
}
