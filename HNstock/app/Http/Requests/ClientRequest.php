<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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

            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'adresse' => 'nullable|string|max:255',
            //'soldemax' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ];
        if ($this->route()->getActionMethod() === 'create') {
            $rules['photo'] = 'required|image';
        }

        return $rules;
    }
}
