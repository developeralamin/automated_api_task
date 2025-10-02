<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Summary of payOrder
     * @param mixed $orderId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payOrder($orderId, Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $payment = $this->paymentService->makePayment($orderId, $request->amount);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'payment' => $payment
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Summary of getPayment
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayment($id)
    {
        $payment = $this->paymentService->getPayment($id);

        if ($payment->order->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => 'success',
            'payment' => $payment
        ]);
    }
}
