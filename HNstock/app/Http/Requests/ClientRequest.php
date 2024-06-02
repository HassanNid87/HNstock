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
            'name' => 'required|min:5',
            'tel' => 'required|min:5',
            'email' => 'required|min:5',

        ];
        if ($this->route()->getActionMethod() === 'create') {
            $rules['photo'] = 'required|image';
        }

        return $rules;
    }
}
