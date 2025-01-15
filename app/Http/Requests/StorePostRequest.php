<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
            return true;

		//if($this->user_id == auth()->user()->id){
		//    return true;
		//}else{
       //     return false;
       // }
    }

    public function rules(): array
    {

        $post = $this->route()->parameter('post');

            $rules = [
                'name' => 'required',
                'slug' => 'required|unique:posts',
                'status' => 'in:1,2',
                'file' => 'image'
            ];

            if($post){
                $rules['slug'] = 'required|unique:posts,slug,' . $post->id;
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