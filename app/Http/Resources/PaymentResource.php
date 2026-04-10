<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'method' => $this->method,
            'amount' => $this->amount,
            'status' => $this->status,
            'reference' => $this->reference,
            'paid_at' => $this->paid_at?->format('d/m/Y H:i'),
        ];
    }
}