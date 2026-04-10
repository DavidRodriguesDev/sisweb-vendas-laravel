<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method' => 'required|in:cash,credit_card,debit_card,pix,boleto',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'method.required' => 'Selecione a forma de pagamento.',
            'method.in' => 'Forma de pagamento inválida.',
            'amount.required' => 'Informe o valor do pagamento.',
            'amount.min' => 'O valor deve ser maior que zero.',
        ];
    }
}