@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Relatório de Vendas</h2>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('reports.index') }}" class="flex gap-4 items-end flex-wrap">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Data Início</label>
            <input type="date" name="date_from" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}" class="px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Data Fim</label>
            <input type="date" name="date_to" value="{{ request('date_to', now()->format('Y-m-d')) }}" class="px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
        <a href="{{ route('reports.sales.pdf') }}?date_from={{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}&date_to={{ request('date_to', now()->format('Y-m-d')) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700" target="_blank">Exportar PDF</a>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Total de Vendas</h3>
        <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($totalSales, 2, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Quantidade de Vendas</h3>
        <p class="text-2xl font-bold text-gray-800">{{ $salesCount }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Ticket Médio</h3>
        <p class="text-2xl font-bold text-gray-800">R$ {{ number_format($salesCount > 0 ? $totalSales / $salesCount : 0, 2, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left py-3 px-4">#</th>
                <th class="text-left py-3 px-4">Cliente</th>
                <th class="text-right py-3 px-4">Total</th>
                <th class="text-center py-3 px-4">Status</th>
                <th class="text-left py-3 px-4">Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $sale->id }}</td>
                <td class="py-2 px-4">{{ $sale->customer?->name ?? 'Sem cliente' }}</td>
                <td class="py-2 px-4 text-right">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                <td class="py-2 px-4 text-center">
                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">{{ ucfirst($sale->status) }}</span>
                </td>
                <td class="py-2 px-4">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection