<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * A private helper method to get the current user's wishlist IDs.
     */
    private function getWishlistProductIds()
    {
        return Auth::check() ? Auth::user()->wishlist()->pluck('products.id')->toArray() : [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);
        $products = $this->applyFilters($request, $query)->paginate(12)->withQueryString();

        // This is the missing line
        $wishlistProductIds = $this->getWishlistProductIds();

        return view('products.index', compact('products', 'wishlistProductIds'));
    }

    /**
     * Display products for a specific category.
     */
    public function byCategory(Request $request, Category $category)
    {
        $categoryIds = $category->allChildren()->pluck('id')->push($category->id);
        $query = Product::whereIn('category_id', $categoryIds)->where('is_active', true);
        $products = $this->applyFilters($request, $query)->paginate(12)->withQueryString();

        // This is the missing line
        $wishlistProductIds = $this->getWishlistProductIds();

        return view('products.index', [
            'products' => $products,
            'currentCategory' => $category,
            'wishlistProductIds' => $wishlistProductIds // Pass it to the view
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category.parent', 'reviews.user');
        $averageRating = $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();
        $categoryPath = [];
        $currentCategory = $product->category;
        while ($currentCategory) {
            array_unshift($categoryPath, $currentCategory);
            $currentCategory = $currentCategory->parent;
        }
        $userHasReviewed = Auth::check() ? $product->reviews()->where('user_id', Auth::id())->exists() : false;

        // This line was already correct
        $wishlistProductIds = $this->getWishlistProductIds();

        return view('products.show', [
            'product' => $product,
            'categoryPath' => $categoryPath,
            'averageRating' => $averageRating,
            'reviewCount' => $reviewCount,
            'userHasReviewed' => $userHasReviewed,
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    /**
     * A private helper method to apply filters to a product query.
     */
    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('brands')) {
            $query->whereIn('brand', $request->brands);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        // Add sorting logic
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query;
    }
}
