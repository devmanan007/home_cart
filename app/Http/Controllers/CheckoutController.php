<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartService::getItems();
        if (empty($items)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $addresses = auth()->user()->addresses()->get();
        $subtotal = CartService::getSubtotal();
        $shipping = CartService::getShippingCost();
        $tax = CartService::getTax();
        $total = CartService::getTotal();

        return view('checkout.index', compact('items', 'addresses', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function placeOrder(CheckoutRequest $request)
    {
        $items = CartService::getItems();
        if (empty($items)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = CartService::getSubtotal();
        $shipping = CartService::getShippingCost();
        $tax = CartService::getTax();
        $total = CartService::getTotal();

        $order = Order::create([
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_country' => $request->shipping_country,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['line_total'],
            ]);

            $item['product']->decrement('stock_quantity', $item['quantity']);
        }

        CartService::clear();

        if ($request->payment_method === 'paypal') {
            return redirect()->route('paypal.create', $order->id);
        }

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Order placed successfully! Payment will be collected on delivery.');
    }

    public function success(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('checkout.success', compact('order'));
    }
}
