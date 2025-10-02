<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::factory()->admin()->create([
            'name' => 'Admin One',
            'email' => 'admin1@gmail.com', 
        ]);

        User::factory()->admin()->create([
            'name' => 'Admin Two',
            'email' => 'admin2@gmail.com', 
        ]);

        //customer
        User::factory()->count(5)->create();

       Category::factory(5)->create()->each(function ($category) {
            Product::factory(10)->create([
                'category_id' => $category->id
            ]);
        });

        Order::factory(10)->create()->each(function ($order) {
            Payment::factory(5)->create([
                    'order_id' => $order->id
            ]);
        });
        
        Cart::factory(5)->create();
    }
}
