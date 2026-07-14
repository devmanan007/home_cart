<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function create(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($order->total, 2, '.', ''),
                    ],
                    'description' => 'Order #' . $order->order_number,
                    'custom_id' => $order->order_number,
                ],
            ],
            'application_context' => [
                'return_url' => route('paypal.capture', $order->id),
                'cancel_url' => route('paypal.cancel', $order->id),
            ],
        ]);

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment could not be initiated. Please try again.');
    }

    public function capture(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $transactionId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;

            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paypal_transaction_id' => $transactionId,
            ]);

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Payment successful! Your order has been confirmed.');
        }

        return redirect()->route('checkout.success', $order->id)
            ->with('error', 'Payment could not be completed. Please contact support.');
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->update([
            'payment_status' => 'failed',
            'status' => 'cancelled',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'Payment was cancelled. Your order has been cancelled.');
    }
}
