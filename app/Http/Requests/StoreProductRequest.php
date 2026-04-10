<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'barcode' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'sku.required' => 'O SKU é obrigatório.',
            'sku.unique' => 'Este SKU já está em uso.',
            'price.required' => 'O preço é obrigatório.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            'stock.required' => 'O estoque é obrigatório.',
            'stock.min' => 'O estoque não pode ser negativo.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}