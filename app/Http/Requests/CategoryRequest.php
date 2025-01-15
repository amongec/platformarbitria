<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       // ray($this->isMethod(method:'post'));
        $imageRules = 'sometimes|image|mimes:jpeg,jpg,png|max:2048';
       if($this->isMethod(method: 'post')){
         $imageRules = 'required|image|mimes:jpeg,jpg,png|max:2048';
       }

        return [
           'name'=>['required','string','max:45' Rule::unique('categories', 'name',)->ignore($this->route('category'))],
           'description'=>['string','max:2000'],
           'image'=> $imagesRules,
        ];
    }
        public function messages(): array
    {
        return [
           'name.required'=>'La categoria es requerida',
           'name.string'=>'La categoria debe ser un texto',
           'name.max'=> 'La categoria no debe exceder los :max caracteres',
           'name.unique' => 'La categoria ya existe',
           'description.required'=>'La descripción es requerida',
           'description.string'=>'La descripción debe ser un texto',
           'description.max'=> 'La descripción no debe exceder los :max caracteres',
           'image.required'=>'La imagen es requerida',
           'image.image' => 'El archivo debe ser una imagen',
           'image.string'=>'La imagen debe ser un texto',
           'image.max'=> 'La imagen no debe exceder los :max caracteres',

        ];
    }
}
