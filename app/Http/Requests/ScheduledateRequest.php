<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduledateRequest extends FormRequest
{

   // public function authorize(): bool
   // {
   //      return auth()->check();
   // }

    public function rules(): array
    {
        return [
            'address_select_service' => ['required'],
            'city_select_service' => ['required'],
            'zipcode_select_service' => ['required'],
            'country_select_service' => ['required'],
            'scheduled_date' => ['required'],
            'scheduled_time' => ['required'],
            'type_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_select_service.required' => 'The :attribute field is required',
           // 'address_select_service.min' => ':attribute requires at least 3 characters',
            'city_select_service.required' => 'The :attribute field is required',
            'zipcode_select_service.required' => 'The :attribute field is required',
            'country_select_service.required' => 'The :attribute field is required',
            'scheduled_date' => 'The :attribute field is required',
            'scheduled_time' => 'The :attribute field is required',
            'type_id' => 'The :attribute field is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'address_select_service' => 'Address',
            'city_select_service' => 'City',
            'zipcode_select_service' => 'Zipcode',
            'country_select_service' => 'Country',
            'scheduled_date' => 'Date',
            'scheduled_time' => 'Time',
            'type_id' => 'Type'
        ];
    }

}
