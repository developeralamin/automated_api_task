<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Customer: place order
    public function placeOrder()
    {
        $order = $this->orderService->placeOrder(Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    }

    // Customer: list own orders
    public function myOrders()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }
}
