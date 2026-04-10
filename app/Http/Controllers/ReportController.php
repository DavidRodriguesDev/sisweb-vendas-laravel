<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'items.product'])
            ->where('status', 'completed');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $sales = $query->orderBy('created_at', 'desc')->get();

        $total = $sales->sum('grand_total');

        return response()->json([
            'sales' => $sales,
            'total' => $total,
            'count' => $sales->count(),
        ]);
    }

    public function salesPdf(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'items.product'])
            ->where('status', 'completed');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->orderBy('created_at', 'desc')->get();
        $total = $sales->sum('grand_total');

        $pdf = Pdf::loadView('reports.sales', compact('sales', 'total'));

        return $pdf->stream('relatorio-vendas.pdf');
    }
}