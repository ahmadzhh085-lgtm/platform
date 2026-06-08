<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'status' => $this->status,
            'total_budget' => $this->total_budget,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
