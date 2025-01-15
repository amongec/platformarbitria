<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'address' => ['required'],
            'district' => ['required'],
            'country' => ['required'],
            'zipcode' => ['required'],
            'billing_zipcode' => ['required'],
            'billing_city' => ['required'],
            'billing_country' => ['required'],
            'payment_id' => ['required'],
            'phone_number' => ['required|digits_between:9,15'],
            'country_code' => ['required']
        ];
    }
}
