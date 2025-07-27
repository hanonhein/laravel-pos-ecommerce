<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the user's order history.
     */
    public function orders()
    {
        // Get the authenticated user's orders, eager load the items
        // and order them by the newest first.
        $orders = Auth::user()
                    ->orders()
                    ->with('items') // Eager load the order items
                    ->latest()      // Same as orderBy('created_at', 'desc')
                    ->paginate(10);  // Paginate the results

        return view('account.orders', compact('orders'));
    }
}
