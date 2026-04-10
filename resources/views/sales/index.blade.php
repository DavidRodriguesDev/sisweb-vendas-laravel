@extends('layouts.app')

@section('title', 'Vendas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Vendas</h2>
    <a href="{{ route('sales.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nova Venda</a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="GET" action="{{ route('sales.index') }}" class="mb-4 flex gap-2 flex-wrap">
        <select name="status" class="px-3 py-2 border rounded">
            <option value="">Todos os status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluída</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 border rounded">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 border rounded">
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
    </form>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left py-3 px-4">#</th>
                <th class="text-left py-3 px-4">Cliente</th>
                <th class="text-left py-3 px-4">Vendedor</th>
                <th class="text-right py-3 px-4">Total</th>
                <th class="text-right py-3 px-4">Desconto</th>
                <th class="text-right py-3 px-4">Total Final</th>
                <th class="text-center py-3 px-4">Status</th>
                <th class="text-left py-3 px-4">Data</th>
                <th class="text-center py-3 px-4">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4">{{ $sale->id }}</td>
                <td class="py-2 px-4">{{ $sale->customer?->name ?? 'Sem cliente' }}</td>
                <td class="py-2 px-4">{{ $sale->user->name }}</td>
                <td class="py-2 px-4 text-right">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                <td class="py-2 px-4 text-right">R$ {{ number_format($sale->discount, 2, ',', '.') }}</td>
                <td class="py-2 px-4 text-right font-bold">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                <td class="py-2 px-4 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : ($sale->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $sale->status === 'completed' ? 'Concluída' : ($sale->status === 'cancelled' ? 'Cancelada' : 'Pendente') }}
                    </span>
                </td>
                <td class="py-2 px-4">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td class="py-2 px-4 text-center">
                    <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-800 mr-1">Ver</a>
                    @if($sale->status !== 'cancelled')
                    <form method="POST" action="{{ route('sales.cancel', $sale) }}" class="inline" onsubmit="return confirm('Confirmar cancelamento?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-red-600 hover:text-red-800">Cancelar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sales->withQueryString()->links() }}
</div>
@endsection