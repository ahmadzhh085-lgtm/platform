<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && (
            $user->hasRole('Super Admin')
            || $user->can('create projects')
            || $user->can('manage projects')
        );
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
            'total_budget' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif|max:2048',
        ];
    }
}
