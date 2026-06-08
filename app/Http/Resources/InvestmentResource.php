<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'investor_id' => $this->investor_id,
            'property_id' => $this->property_id,
            'amount' => $this->amount,
            'expected_profit' => $this->expected_profit,
            'status' => $this->status,
            'payment_date' => $this->payment_date,
            'investor' => $this->whenLoaded('investor', [
                'id' => $this->investor?->id,
                'full_name' => $this->investor?->full_name,
                'email' => $this->investor?->email,
                'phone' => $this->investor?->phone,
            ]),
            'property' => $this->whenLoaded('property', [
                'id' => $this->property?->id,
                'project_id' => $this->property?->project_id,
                'title' => $this->property?->title,
                'type' => $this->property?->type,
                'price' => $this->property?->price,
                'location' => $this->property?->location,
                'status' => $this->property?->status,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
