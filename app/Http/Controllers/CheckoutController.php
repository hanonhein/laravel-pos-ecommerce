<?php

namespace App\Http\Controllers;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form.
     */
    public function create()
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();

        // Redirect to the cart page if the cart is empty
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.create', compact('cart'));
    }
    /**
     * Store a newly created order in storage.
     */
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($request, $user, $cart) {

            // First, calculate the correct total amount from the cart items
            $totalAmount = $cart->cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });

            // Create the Order with the correct total
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount, // Use the correct total
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
            ]);

            // Create the Order Items with the correct price
            foreach ($cart->cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->price, // Use the price from the cart item
                    'quantity' => $item->quantity,
                ]);
            }

            // Delete the cart
            $cart->delete();

            return $order;
        });

        return redirect()->route('order.success', $order)->with('success', 'Your order has been placed successfully!');
    }
}
