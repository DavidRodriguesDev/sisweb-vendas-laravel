<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #f0f0f0; }
        h1 { text-align: center; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Relatório de Vendas</h1>
    <div class="header">
        <span>Período: {{ $dateFrom ?? '' }} a {{ $dateTo ?? '' }}</span>
        <span>Gerado em: {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Subtotal</th>
                <th>Desconto</th>
                <th>Total</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer?->name ?? 'Sem cliente' }}</td>
                <td>{{ $sale->user->name }}</td>
                <td class="text-right">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($sale->discount, 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right">Total Geral:</td>
                <td class="text-right">R$ {{ number_format($total ?? $sales->sum('grand_total'), 2, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>