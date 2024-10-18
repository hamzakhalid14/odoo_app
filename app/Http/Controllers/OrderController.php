<?php

namespace App\Http\Controllers;
use app\Models\Order;
use Illuminate\Http\Request;




class OrderController extends Controller
{
    // Display a listing of the orders
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    // Store a newly created order in storage
    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return response()->json($order, 201);
    }

    // Display the specified order
    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    // Update the specified order in storage
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update($request->all());
        return response()->json($order);
    }

    // Remove the specified order from storage
    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(null, 204);
    }
}