@extends('layouts.app')

@section('title', $product->exists ? 'Editar Produto' : 'Novo Produto')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $product->exists ? 'Editar Produto' : 'Novo Produto' }}</h2>

    <form method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
        @csrf
        @if($product->exists) @method('PUT') @endif

        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Código de Barras</label>
                    <input type="text" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Preço *</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Custo</label>
                    <input type="number" name="cost" step="0.01" value="{{ old('cost', $product->cost ?? '0') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Estoque</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '0') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Estoque Mínimo</label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock ?? '0') }}"
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Categoria</label>
                <select name="category_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sem categoria</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" {{ old('active', ($product->active ?? true) ? '1' : '0') ? 'checked' : '' }} class="rounded">
                    <span class="text-gray-700 text-sm font-bold">Ativo</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            </div>
        </div>
    </form>
</div>
@endsection