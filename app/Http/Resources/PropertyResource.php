<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'title' => $this->title,
            'type' => $this->type,
            'price' => $this->price,
            'city' => $this->city,
            'location' => $this->location,
            'area' => $this->area,
            'bedrooms' => $this->bedrooms,
            'status' => $this->status,
            'description' => $this->description,
            'image' => $this->image,
            'project' => $this->whenLoaded('project', function () {
                return [
                    'id' => $this->project?->id,
                    'name' => $this->project?->name,
                    'city' => $this->project?->city,
                    'location' => $this->project?->location,
                    'status' => $this->project?->status,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
