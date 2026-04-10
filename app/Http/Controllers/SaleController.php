<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaleController extends Controller
{
    public function __construct(private SaleService $saleService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Sale::with(['customer', 'user', 'items.product', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        return SaleResource::collection(
            $query->orderBy('created_at', 'desc')->paginate($request->integer('per_page', 15))
        );
    }

    public function store(Request $request): SaleResource
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:cash,credit_card,debit_card,pix,boleto',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $sale = $this->saleService->createSale($validated, $request->user());

        return new SaleResource($sale->load(['customer', 'user', 'items.product', 'payments']));
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale->load(['customer', 'user', 'items.product', 'payments']));
    }

    public function cancel(Sale $sale)
    {
        $this->saleService->cancelSale($sale);

        return new SaleResource($sale->fresh()->load(['customer', 'user', 'items.product', 'payments']));
    }
}