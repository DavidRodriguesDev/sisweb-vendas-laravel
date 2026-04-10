@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Produtos</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Produto</a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome, SKU ou código de barras..." class="flex-1 px-3 py-2 border rounded">
        <select name="category_id" class="px-3 py-2 border rounded">
            <option value="">Todas categorias</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
    </form>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left py-3 px-4">SKU</th>
                <th class="text-left py-3 px-4">Nome</th>
                <th class="text-left py-3 px-4">Categoria</th>
                <th class="text-right py-3 px-4">Preço</th>
                <th class="text-right py-3 px-4">Estoque</th>
                <th class="text-center py-3 px-4">Status</th>
                <th class="text-center py-3 px-4">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $product->sku }}</td>
                <td class="py-2 px-4">{{ $product->name }}</td>
                <td class="py-2 px-4">{{ $product->category?->name ?? '-' }}</td>
                <td class="py-2 px-4 text-right">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                <td class="py-2 px-4 text-right {{ $product->isLowStock() ? 'text-orange-600 font-bold' : '' }}">{{ $product->stock }}</td>
                <td class="py-2 px-4 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $product->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td class="py-2 px-4 text-center">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-2">Editar</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Confirmar exclusão?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}
</div>
@endsection