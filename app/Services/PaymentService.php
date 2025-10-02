<?php

namespace App\Services;

use App\Constants\GlobalConstant;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
class PaymentService
{
    /**
     * Mock payment for an order
     */
    public function makePayment(int $orderId, float $amount): Payment
    {
        $order = Order::findOrFail($orderId);

        if ($amount != $order->total_amount) {
            throw new \Exception('Payment amount must match order total.');
        }

        return DB::transaction(function () use ($order, $amount) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount'   => $amount,
                'status'   => GlobalConstant::SUCCESS, 
            ]);
            $order->save();

            return $payment;
        });
    }

    /**
     * Get payment details
     */
    public function getPayment(int $paymentId): Payment
    {
        return Payment::with('order')->findOrFail($paymentId);
    }
}
