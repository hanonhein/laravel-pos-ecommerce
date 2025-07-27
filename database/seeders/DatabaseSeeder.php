<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
    // }
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate tables in the correct order
        Product::truncate();
        Category::truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Create 5 categories, and for each one, create 10 products
        Category::factory(5)->has(Product::factory()->count(10))->create();
    }
}
