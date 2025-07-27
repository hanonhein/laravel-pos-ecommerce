<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        // Fetch all orders, eager load the user relationship
        // Order by the newest first and paginate
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }
    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Eager load the user and the items with their associated products
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }
    /**
     * Update the specified order's status in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
        ]);

        $order->update(['status' => $validated['status']]);

        // 3. This is the new logic to send the email
        // We check if the new status is 'shipped'
        if ($validated['status'] === 'shipped') {
            // Send the OrderShipped email to the user who placed the order
            Mail::to($order->user->email)->send(new OrderShipped($order));
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully!');
    }
}
