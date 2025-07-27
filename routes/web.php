<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; // Add this alias
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\UserController as AdminUserController; // Add this alias

use App\Http\Controllers\Auth\SocialiteController; // Add this import for SocialiteController
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\WishlistController; // Add this at the top


// Route::get('/test-email', function () {
//     try {
//         Mail::raw('Test email from E-Shop!', function ($message) {
//             $message->to('heinthuyakyawextra@gmail.com')
//                     ->subject('Laravel Email Test');
//         });
//         return 'Email sent successfully!';
//     } catch (Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });

// Route::get('/check-mail-config', function () {
//     return [
//         'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
//         'MAIL_FROM_ADDRESS' => config('mail.from.address'),
//         'MAIL_HOST' => config('mail.mailers.smtp.host'),
//     ];
// });


Route::get('/', [ProductController::class, 'index'])->name('home');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

});

Route::get('/dashboard', fn() => redirect()->route('products.index'))->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php

// Replace the old Magic Link routes with these three new ones
Route::get('/login/magic', [MagicLinkController::class, 'showLinkRequestForm'])->name('magic-link.request');
Route::post('/login/magic', [MagicLinkController::class, 'sendLink']);
Route::get('/login/magic/verify', [MagicLinkController::class, 'showVerifyForm'])->name('magic-link.verify.form');
Route::post('/login/magic/verify', [MagicLinkController::class, 'loginWithToken'])->name('magic-link.verify');

//for reviews
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Checkout Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/my-orders', [AccountController::class, 'orders'])->name('account.orders');
});

// In routes/web.php
Route::get('/order/success/{order}', function (App\Models\Order $order) {
    // Make sure the logged-in user owns this order
    if ($order->user_id !== Auth::id()) {
        abort(404);
    }
    return view('checkout.success', compact('order'));
})->name('order.success')->middleware('auth');


// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Add this single line for product management
    Route::resource('products', AdminProductController::class);

    // Add this new line for category management
    Route::resource('categories', AdminCategoryController::class);

    // Add this new line for viewing orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

    // Add this new route for viewing a single order
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

    // Add this new route for updating the order status
    Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    // Add these two new routes for user management

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
});

// This route will be called by our JavaScript to fetch sub-categories
Route::get('/api/subcategories/{category}', function (App\Models\Category $category) {
    return response()->json($category->children);
})->name('api.subcategories');

// Add this new route for filtering by category
Route::get('/category/{category:slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');

Route::get('/search', [SearchController::class, 'results'])->name('search.results');

// Google Socialite Routes
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');






require __DIR__.'/auth.php';
