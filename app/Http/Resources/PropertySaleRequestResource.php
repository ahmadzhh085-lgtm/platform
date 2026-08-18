<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertySaleRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'seller_name' => $this->seller_name,
            'seller_phone' => $this->seller_phone,
            'seller_email' => $this->seller_email,
            'seller_national_id' => $this->seller_national_id,
            'title' => $this->title,
            'type' => $this->type,
            'price' => $this->price,
            'city' => $this->city,
            'location' => $this->location,
            'area' => $this->area,
            'bedrooms' => $this->bedrooms,
            'description' => $this->description,
            'notes' => $this->notes,
            'status' => $this->status,
            'admin_notes' => $this->admin_notes,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_at' => $this->reviewed_at,
            'project_id' => $this->project_id,
            'user' => $this->whenLoaded('user', [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ]),
            'project' => $this->whenLoaded('project', [
                'id' => $this->project?->id,
                'name' => $this->project?->name,
                'city' => $this->project?->city,
                'location' => $this->project?->location,
                'status' => $this->project?->status,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
