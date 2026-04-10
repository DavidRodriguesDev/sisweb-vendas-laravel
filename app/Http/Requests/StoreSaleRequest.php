<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:cash,credit_card,debit_card,pix,boleto',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Adicione pelo menos um item à venda.',
            'items.min' => 'Adicione pelo menos um item à venda.',
            'items.*.product_id.required' => 'Selecione um produto.',
            'items.*.product_id.exists' => 'Produto não encontrado.',
            'items.*.quantity.required' => 'Informe a quantidade.',
            'items.*.quantity.min' => 'A quantidade deve ser no mínimo 1.',
            'payment_method.required' => 'Selecione a forma de pagamento.',
            'payment_method.in' => 'Forma de pagamento inválida.',
        ];
    }
}