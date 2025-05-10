<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'message' => 'Hooray!! Successfully fetched customers',
            'data' => $customers
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone_number' => 'nullable',
        ]);
    
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');
        $customer->save();
    
        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $customer,
        ], 201);
    }


    public function show(Customer $customer)
    {
        return response()->json([
            'message' => 'Successfully fetched customer',
            'data' => $customer
        ], 200);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'nullable',
        ]);

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');
        $customer->save();

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => $customer,
        ], 200);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([
            'message' => 'Customer successfully deleted'
        ], 200);
    }
}
