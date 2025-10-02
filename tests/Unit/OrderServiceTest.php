<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_place_order_creates_order_and_clears_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 50]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $orderService = new OrderService();
        $order = $orderService->placeOrder($user->id);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'total_amount' => 100,
        ]);

        $this->assertDatabaseCount('carts', 0);
    }
}
