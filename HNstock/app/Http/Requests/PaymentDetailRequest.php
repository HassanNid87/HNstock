<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentDetailRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payment_id' => 'required|exists:payments,id|numeric',
            'sale_id' => 'required|exists:sales,id|numeric',
            'NFact' => 'required|string|max:255',
            'DateFact' => 'required|date',
            'mttc' => 'required|numeric|min:0',
            'montant_regle' => 'required|numeric|min:0',
        ];
    }
}
