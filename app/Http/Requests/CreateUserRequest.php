<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
   // public function authorize(): bool
   // {
        //return true;
      //  return auth()->check();
   // }

    public function rules(): array
    {
        return [
            "name" => ["required"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:6"],
            "roles" => ["required", "array"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The :attribute field is required",

            "email.required" => "The :attribute field is required",
            "email.email" => ":attribute requires to be an array",
            "email.unique" => ":attribute is already in use",

            "password.required" => "The :attribute field is required",
            "password.min" => ":attribute requires at least 6 characters",

            "roles.required" => "The :attribute field is required",
            "roles.array" => ":attribute requires to be an array",
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => "Name User",
            "email" => "E-mail",
            "password" => "Password",
            "roles" => "User Roles",
        ];
    }
}