<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Provide product suggestions for autocomplete.
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');

        // Find products where the name is like the search query
        // We limit the results to the top 5 for performance
        $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->limit(5)
                            ->get();

        // Return the results as a JSON response
        return response()->json($products);
    }
    /**
     * Display the full search results page.
     */
    public function results(Request $request)
    {
        // Validate that the search query is present
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');

        // Find all products that match the search query and paginate them
        $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->where('is_active', true)
                            ->paginate(12);

        // Return the results view, passing the products and the original query
        return view('search.results', compact('products', 'query'));
    }
}
