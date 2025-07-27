<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use Illuminate\Support\Facades\View; // 1. Import the View facade
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view) {
            $categoriesForSidebar = Category::whereNull('parent_id')->with('allChildren')->get();
            $brandsForSidebar = Product::whereNotNull('brand')->distinct()->pluck('brand');

            // 2. Add the logic to get the cart item count
            $cartItemCount = 0;
            if (Auth::check()) {
                $cart = Auth::user()->cart;
                if ($cart) {
                    // We sum the 'quantity' of all items in the cart
                    $cartItemCount = $cart->cartItems()->sum('quantity');
                }
            }

            // 3. Pass all variables to the view
            $view->with('categoriesForSidebar', $categoriesForSidebar)
                 ->with('brandsForSidebar', $brandsForSidebar)
                 ->with('cartItemCount', $cartItemCount);
        });
    }
}
