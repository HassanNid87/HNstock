<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
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
            'NFact' => 'required',
            'DateFact' => 'required|',
            'mht' => 'required|numeric',
            'ttva' => 'required|numeric',
            'mtva' => 'required|numeric',
            'tremise' => 'required|numeric',
            'mremise' => 'required|numeric',
            'mttc' => 'required|numeric',
//            'montant_restant' => 'required|numeric',
            'client_id' => 'required',
            'product_id' => ['required' , 'array' , 'min:1'],
            'product_id.*' => ['required' , 'numeric', Rule::exists(Product::class , 'id')],
        ];

        return $rules;
    }


}
