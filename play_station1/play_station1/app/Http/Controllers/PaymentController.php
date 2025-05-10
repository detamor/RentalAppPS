<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.customer', 'order.game')->get();
        return response()->json(['data' => $payments], 200);
    }

    public function show(Payment $payment)
    {
        $payment->load('order.customer', 'order.game');
        return response()->json(['data' => $payment], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'date' => 'required|date',
            'method' => 'required',
        ]);

        $payment = Payment::create($request->all());

        return response()->json(['data' => $payment], 201);
    }


    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'date' => 'sometimes|required|date',
            'method' => 'sometimes|required',
        ]);

        $payment->update($request->all());

        return response()->json(['data' => $payment], 200);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted'], 200);
    }
}
