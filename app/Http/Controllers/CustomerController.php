<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('document', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        return CustomerResource::collection(
            $query->orderBy('name')->paginate($request->integer('per_page', 15))
        );
    }

    public function store(Request $request): CustomerResource
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'document' => 'nullable|string|max:20',
        ]);

        $customer = Customer::create($validated);

        return new CustomerResource($customer);
    }

    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer->load('sales'));
    }

    public function update(Request $request, Customer $customer): CustomerResource
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => "nullable|email|unique:customers,email,{$customer->id}",
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'document' => 'nullable|string|max:20',
        ]);

        $customer->update($validated);

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Cliente removido com sucesso']);
    }
}