<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id ?? $this->route('product');

        return [
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|max:50|unique:products,sku,' . $productId,
            'barcode' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.unique' => 'Este SKU já está em uso.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            'stock.min' => 'O estoque não pode ser negativo.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}