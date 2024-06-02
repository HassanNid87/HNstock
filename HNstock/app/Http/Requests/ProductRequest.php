<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' =>'required|min:5',
            'description' =>'required|min:5',
            'quantity' =>'required|numeric|min:1',
            'priceA' =>'required|numeric',
            'priceV' =>'required|numeric',
            'category_id' =>'required|numeric',
        ] ;
        if ($this->route()->getActionMethod() === 'create') {
            $rules['image'] = 'required|image';
        }

        return $rules;
    }
}
