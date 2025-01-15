<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClusterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
            return true;

		//if($this->user_id == auth()->user()->id){
		//    return true;
		//}else{
       //     return false;
       // }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $cluster = $this->route()->parameter('cluster');

            $rules = [
                'name' => 'required',
                'slug' => 'required|unique:clusters',
                'status' => 'required|in:1,2',
                'file' => 'image'
            ];

            if($cluster){
                $rules['slug'] = 'required|unique:clusters,slug,' . $cluster->id;
            }

            if($this->status == 2){
                $rules =  array_merge($rules, [
                    'excerpt' => 'required',
                    'body' => 'required'
                ]);
            }
            return $rules;
    }
}