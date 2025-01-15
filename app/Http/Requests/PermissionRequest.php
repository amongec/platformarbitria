<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        // return auth()->check();
    }

    public function rules(): array
    {
        return [
            "name" => ["required"]
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The :attribute field is required"
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => "Name Permission"
        ];
    }
}