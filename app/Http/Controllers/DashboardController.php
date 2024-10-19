<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $customerCount = Customer::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $totalRevenue = Order::sum('total_amount');

        $orderStatusData = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $orderStatusLabels = array_keys($orderStatusData);
        $orderStatusData = array_values($orderStatusData);

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        $topProductsLabels = $topProducts->pluck('product.name')->toArray();
        $topProductsData = $topProducts->pluck('total_quantity')->toArray();

        $recentOrders = Order::with('customer')->latest()->take(10)->get();

        return view('dashboard', compact(
            'customerCount',
            'productCount',
            'orderCount',
            'totalRevenue',
            'orderStatusLabels',
            'orderStatusData',
            'topProductsLabels',
            'topProductsData',
            'recentOrders'
        ));
    }
}