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
            'location' => $this->location,
            'area' => $this->area,
            'status' => $this->status,
            'image' => $this->image,
            'project' => $this->whenLoaded('project', function () {
                return [
                    'id' => $this->project?->id,
                    'name' => $this->project?->name,
                    'location' => $this->project?->location,
                    'status' => $this->project?->status,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
