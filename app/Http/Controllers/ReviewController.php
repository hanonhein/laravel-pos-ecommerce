<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // 2. Check if the user has already reviewed this product
        $existingReview = $product->reviews()->where('user_id', Auth::id())->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        // 3. Create the new review
        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // 4. Redirect back to the product page with a success message
        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
