<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeapotRequest extends FormRequest
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

        $imageRules = 'sometimes|image|mime:jpeg,jpg,png|max:2048';
        if($this->method('post')){
            $imageRules = 'required|image|mimes:jpeg,jpg,png|max:2048';
        }
        return [
          'name' => ['required', 'string', 'max:45', Rule::unique('teapots', 'name')->ignore($this->route('teapot'))], 
          'description' => ['required', 'string', 'max:2000'],
          'category_id' => ['required', 'exists:categories,id'],
          'price' => ['required', 'numeric', 'min:0'],
          'stock' => ['required', 'integer', 'min:0'],
          'image' => $imageRules,
        ];
    }

    public function messages(): array{
        return[
            'name.required'=>'El nombre es obligatorio',
            'name.string'=>'El nombre debe der un texto',    
            'name.max'=>'El nombre no puede superarar los 45 caracters',    
            'name.unique'=>'El teapot ya existe',    
            'description.required'=>'La description es obligatoria',    
            'description.string'=>'La descriptión debe ser un texto',    
            'category_id.required'=>'La categoria es obligatoria',    
            'category_id.exist'=>'La categoria seleccionada no existe',    
            'price.required'=>'El precio es obligatorio',    
            'price.numeric'=>'El precio debe ser un número',    
            'price.min'=>'El precio no puede ser negativo',    
            'stock.required'=>'EL estock es obligatorio', 
            'stock.integer'=>'El estoc debe ser un número entero', 
            'stock.min'=>'El estoc no puede ser negaativo', 
            'image.required'=>'La imagen es requerida',    
            'image.image'=>'EL archivo debe ser una imagen', 
            'image.mimes'=>'La imagen debe ser del tipo: jpeg, jpg, png', 
            'image.max'=>'La imagen no debe exceder los :max kilobytes',
        ];
    }
}
