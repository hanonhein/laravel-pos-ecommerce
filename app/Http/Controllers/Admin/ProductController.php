<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Import the Storage facade for deleting files
use Illuminate\Validation\Rule; // Import the Rule class for complex validation


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        // Return the view and pass the products to it
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // We only need the top-level categories for the first dropdown
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.products.create', compact('parentCategories'));
    }

    // public function create()
    // {
    //     // Let's try to return a view we KNOW exists to test the system.
    //     return view('admin.dashboard');
    // }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price', // Add validation for sale_price
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null, // Add sale_price
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Eager load the category and its parent relationships
        $product->load('category.parent');

        // Get all top-level categories for the first dropdown
        $parentCategories = Category::whereNull('parent_id')->get();

        // Calculate the full category path for the product
        $categoryPath = [];
        $currentCategory = $product->category;
        while ($currentCategory) {
            // Add the category to the beginning of the path array
            array_unshift($categoryPath, $currentCategory);
            $currentCategory = $currentCategory->parent;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'parentCategories' => $parentCategories,
            'categoryPath' => $categoryPath, // Pass the path to the view
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price', // Add validation for sale_price
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null, // Add sale_price
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Delete the product's image from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Delete the product from the database
        $product->delete();

        // 3. Redirect back to the product list with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }


}
