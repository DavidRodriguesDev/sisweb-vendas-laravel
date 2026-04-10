<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();

        $salesToday = Sale::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('grand_total');

        $salesMonth = Sale::where('status', 'completed')
            ->where('created_at', '>=', $monthStart)
            ->sum('grand_total');

        $salesCountToday = Sale::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->count();

        $salesCountMonth = Sale::where('status', 'completed')
            ->where('created_at', '>=', $monthStart)
            ->count();

        $topProducts = Product::select('products.id', 'products.name', 'products.sku', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', 'completed')
            ->where('sales.created_at', '>=', $monthStart)
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->where('active', true)
            ->get();

        $recentSales = Sale::with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $salesByDay = Sale::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'sales_today' => $salesToday,
            'sales_month' => $salesMonth,
            'sales_count_today' => $salesCountToday,
            'sales_count_month' => $salesCountMonth,
            'top_products' => $topProducts,
            'low_stock_products' => $lowStockProducts,
            'recent_sales' => $recentSales,
            'sales_by_day' => $salesByDay,
        ]);
    }
}