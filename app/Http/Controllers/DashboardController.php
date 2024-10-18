<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $customerCount = Customer::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('customerCount', 'productCount', 'orderCount', 'recentOrders'));
    }
}