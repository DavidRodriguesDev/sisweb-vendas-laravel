<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getSalesSummary(string $dateFrom, string $dateTo): array
    {
        $sales = Sale::where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->with(['customer', 'user', 'items.product'])
            ->get();

        return [
            'total_sales' => $sales->sum('grand_total'),
            'total_discount' => $sales->sum('discount'),
            'count' => $sales->count(),
            'average_ticket' => $sales->count() > 0 ? $sales->sum('grand_total') / $sales->count() : 0,
            'sales' => $sales,
        ];
    }

    public function getTopProducts(string $dateFrom, string $dateTo, int $limit = 10): \Illuminate\Support\Collection
    {
        return Sale::join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->select('products.name', 'products.sku', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.subtotal) as total_revenue'))
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get();
    }
}