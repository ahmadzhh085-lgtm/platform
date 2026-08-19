<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
            'total_budget' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif|max:2048',
        ];
    }
}
