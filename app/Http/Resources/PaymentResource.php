<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'investment_id' => $this->investment_id,
            'amount' => $this->amount,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'status' => $this->status,
            'investment' => $this->whenLoaded('investment', [
                'id' => $this->investment?->id,
                'investor_id' => $this->investment?->investor_id,
                'property_id' => $this->investment?->property_id,
                'amount' => $this->investment?->amount,
                'status' => $this->investment?->status,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
