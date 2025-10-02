<?php

namespace App\Services;

use App\Constants\GlobalConstant;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderPlacedNotification;
class OrderService
{
    public function placeOrder(int $userId): Order
    {
        $cartItems = Cart::where('user_id', $userId)->get();
        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return DB::transaction(function () use ($userId, $cartItems, $total) {
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $total,
                'status' => GlobalConstant::PENDING,
            ]);
            if($order){
              $order->user->notify(new OrderPlacedNotification($order));
            }
            // Clear cart
            Cart::where('user_id', $userId)->delete();
            

            return $order;
        });
    }

    public function getUserOrders(int $userId)
    {
        return Order::with('payments', 'cartItems.product')
                ->where('user_id', $userId)->latest()->get();
    }

    //admin shows all orders
    public function getAllOrders()
    {
        return Order::with('user', 'payments', 'cartItems.product')->latest()->get();
    }

    //admin can update the status
    public function updateStatus(int $orderId, string $status): Order
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();
        return $order;
    }
}
