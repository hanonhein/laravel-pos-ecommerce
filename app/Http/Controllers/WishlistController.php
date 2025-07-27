<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistProducts = Auth::user()->wishlist()->paginate(10);
        return view('wishlist.index', compact('wishlistProducts'));
    }

    /**
     * Add or remove a product from the user's wishlist.
     */
    public function toggle(Product $product)
    {
        // The toggle method is a convenient way to add/remove a record
        Auth::user()->wishlist()->toggle($product->id);

        return redirect()->back();
    }
}
