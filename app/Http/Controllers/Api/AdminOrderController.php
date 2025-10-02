<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Notifications\OrderConfirmedNotification;
use App\Constants\GlobalConstant;
class AdminOrderController extends Controller
{
      protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
  
    public function allOrders()
    {
        $orders = $this->orderService->getAllOrders();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $order = $this->orderService->updateStatus($id, $request->status);

         if ($order->status === GlobalConstant::CONFIRMED) {
            $order->user->notify(new OrderConfirmedNotification($order));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated',
            'order' => $order
        ]);
    }
}
