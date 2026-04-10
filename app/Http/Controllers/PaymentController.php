<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Sale $sale): PaymentResource
    {
        $validated = $request->validate([
            'method' => 'required|in:cash,credit_card,debit_card,pix,boleto',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string',
        ]);

        $payment = $sale->payments()->create([
            'method' => $validated['method'],
            'amount' => $validated['amount'],
            'status' => 'confirmed',
            'reference' => $validated['reference'] ?? null,
            'paid_at' => now(),
        ]);

        return new PaymentResource($payment);
    }

    public function index(Sale $sale)
    {
        return PaymentResource::collection($sale->payments);
    }
}