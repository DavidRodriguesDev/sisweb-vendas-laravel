<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return view('dashboard.index', compact(
            'salesToday', 'salesMonth', 'salesCountToday', 'salesCountMonth',
            'topProducts', 'lowStockProducts', 'recentSales'
        ));
    }
}