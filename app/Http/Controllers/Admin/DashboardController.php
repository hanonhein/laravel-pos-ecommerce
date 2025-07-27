<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        // Fetch the counts from the database
        $productCount = Product::count();
        $orderCount = Order::count();
        $userCount = User::count();

        // Pass the counts to the view
        return view('admin.dashboard', compact('productCount', 'orderCount', 'userCount'));
    }
}
