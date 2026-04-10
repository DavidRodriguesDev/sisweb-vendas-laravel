@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Vendas Hoje</h3>
        <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($salesToday, 2, ',', '.') }}</p>
        <p class="text-gray-500 text-sm mt-1">{{ $salesCountToday }} vendas</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Vendas do Mês</h3>
        <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($salesMonth, 2, ',', '.') }}</p>
        <p class="text-gray-500 text-sm mt-1">{{ $salesCountMonth }} vendas</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Produtos em Baixa</h3>
        <p class="text-2xl font-bold text-orange-600">{{ $lowStockProducts->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Top Produtos</h3>
        <p class="text-2xl font-bold text-green-600">{{ $topProducts->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Sales --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Vendas Recentes</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Cliente</th>
                    <th class="text-left py-2">Total</th>
                    <th class="text-left py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSales as $sale)
                <tr class="border-b">
                    <td class="py-2">{{ $sale->customer?->name ?? 'Sem cliente' }}</td>
                    <td class="py-2">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                    <td class="py-2">
                        <span class="px-2 py-1 rounded text-xs {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : ($sale->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Low Stock --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Produtos em Baixa</h3>
        @if($lowStockProducts->isEmpty())
        <p class="text-gray-500">Todos os produtos com estoque suficiente.</p>
        @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Produto</th>
                    <th class="text-left py-2">Estoque</th>
                    <th class="text-left py-2">Mínimo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                <tr class="border-b">
                    <td class="py-2">{{ $product->name }}</td>
                    <td class="py-2 text-orange-600 font-bold">{{ $product->stock }}</td>
                    <td class="py-2">{{ $product->min_stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection