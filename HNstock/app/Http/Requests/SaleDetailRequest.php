<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleDetailRequest extends FormRequest
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
/**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $rules = [

            'sale_id'=>'required|numeric',
            'product_id'=>'required|numeric',
            'quantity'=>'required|numeric',
            'unit_price'=>'required|numeric',
            'total'=>'required|numeric',

        ] ;
              return $rules;
    }
}
