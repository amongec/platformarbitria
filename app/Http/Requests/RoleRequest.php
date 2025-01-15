<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

   // public function authorize(): bool
   // {
   //      return auth()->check();
   // }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'permissions' => ['required', 'array']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute field is required',
            'permissions.required' => 'The :attribute field is required',
            'permissions.array' => ':attribute requires to be an array'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name Role',
            'permissions' => 'Permissions Role'
        ];
    }
}
