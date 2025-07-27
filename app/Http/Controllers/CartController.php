<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        if (Auth::check()) {
            // User is logged in, get cart from database
            $cart = Auth::user()->cart()->with('cartItems.product')->first();
        } else {
            // User is a guest, get cart from session
            $cart = session()->get('cart', []);
        }

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        $price = $product->sale_price ?? $product->price;

        if (Auth::check()) {
            // --- LOGGED-IN USER LOGIC ---
            $cart = Auth::user()->cart()->firstOrCreate([]);
            $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->price = $price;
                $cartItem->save();
            } else {
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
        } else {
            // --- GUEST USER LOGIC ---
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                // If item exists, update quantity
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                // If item does not exist, add it
                $cart[$product->id] = [
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $price,
                    "image" => $product->image,
                    "slug" => $product->slug
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update a cart item.
     */
    public function update(Request $request, $productId)
    {
        $quantity = $request->input('quantity');

        if (Auth::check()) {
            // --- LOGGED-IN USER LOGIC ---
            $cartItem = CartItem::find($productId); // Here $productId is actually cart_item_id
            if($cartItem && $cartItem->cart->user_id == Auth::id()) {
                $cartItem->update(['quantity' => $quantity]);
                return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
            }
        } else {
            // --- GUEST USER LOGIC ---
            $cart = session()->get('cart');
            if(isset($cart[$productId]) && $quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
            }
        }
        return redirect()->route('cart.index')->with('error', 'Something went wrong.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($productId)
    {
        if (Auth::check()) {
            // --- LOGGED-IN USER LOGIC ---
            $cartItem = CartItem::find($productId); // Here $productId is actually cart_item_id
             if($cartItem && $cartItem->cart->user_id == Auth::id()) {
                $cartItem->delete();
                return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
            }
        } else {
            // --- GUEST USER LOGIC ---
            $cart = session()->get('cart');
            if(isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
            }
        }
        return redirect()->route('cart.index')->with('error', 'Something went wrong.');
    }
}
