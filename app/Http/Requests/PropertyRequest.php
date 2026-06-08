<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'required|integer|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
            'image' => 'nullable|string|max:255',
        ];
    }
}
