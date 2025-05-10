<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Retrieve all orders with associated user and product data
    public function index()
    {
        $orders = Order::with('customer:id,name', 'game')->get();
        return response()->json(['message' => 'Successfully fetched orders', 'data'
        => $orders], 200);
    }
    // Create a new order with user ID, product ID, quantity, total price, and status
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'game_id' => 'required|exists:games,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);
        $order = Order::create($request->all());
        return response()->json(['message' => 'Order successfully created', 'data' =>
        $order], 201);
    }
    // Retrieve an order by ID with associated user and product data
    public function show(Order $order)
    {
        $order->load(['customer', 'game']);
        return response()->json(['message' => 'Successfully fetched order', 'data' =>
        $order]);
    }
    // Update an existing order with optional user ID, product ID, quantity, total price, and status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'game_id' => 'sometimes|required|exists:games,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'total_price' => 'sometimes|required|numeric|min:0',
            'status' =>
            'sometimes|required|in:pending,processing,completed,canceled',
        ]);
        $order->update($request->all());
        return response()->json(['message' => 'Order successfully updated', 'data' =>
        $order]);
    }
    // Delete an existing order by ID
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order successfully deleted'], 200);
    }
}
