<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPurchaseRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'buyer_name' => $this->buyer_name,
            'buyer_phone' => $this->buyer_phone,
            'buyer_email' => $this->buyer_email,
            'buyer_national_id' => $this->buyer_national_id,
            'offer_amount' => $this->offer_amount ?? $this->offer_price,
            'offer_price' => $this->offer_price ?? $this->offer_amount,
            'notes' => $this->notes,
            'status' => $this->status,
            'admin_notes' => $this->admin_notes,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_at' => $this->reviewed_at,
            'project' => $this->whenLoaded('project', [
                'id' => $this->project?->id,
                'name' => $this->project?->name,
                'location' => $this->project?->location,
                'status' => $this->project?->status,
            ]),
            'user' => $this->whenLoaded('user', [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
