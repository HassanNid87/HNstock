<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public const MIN_PHONE_NUMBER_LENGTH = 10;
    public const MAX_PHONE_NUMBER_LENGTH = 10;

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
        $telRule = $this->getPhoneRule();

        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'tel' => 'required|' . $telRule,
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'whatsapp' => ["nullable", $telRule],
        ];

        if ($this->route()->getActionMethod() === 'store') {
            $rules['photo'] = 'required|image';
        }

        return $rules;
    }

    /**
     * @return string
     */
    public function getPhoneRule(): string
    {
        $telRule = self::MIN_PHONE_NUMBER_LENGTH === self::MAX_PHONE_NUMBER_LENGTH
            ? "digits:" . self::MIN_PHONE_NUMBER_LENGTH
            : sprintf("digits_between:%s,%s", self::MIN_PHONE_NUMBER_LENGTH, self::MAX_PHONE_NUMBER_LENGTH);
        return $telRule;
    }
}
