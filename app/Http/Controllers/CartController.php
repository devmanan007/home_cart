<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartService::getItems();
        $subtotal = CartService::getSubtotal();
        $shipping = CartService::getShippingCost();
        $tax = CartService::getTax();
        $total = CartService::getTotal();

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $result = CartService::add(
            $request->product_id,
            $request->integer('quantity', 1)
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        return redirect()->route('cart')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $result = CartService::update($id, $request->integer('quantity'));

        if ($request->expectsJson()) {
            return response()->json([
                ...$result,
                'subtotal' => CartService::getSubtotal(),
                'shipping' => CartService::getShippingCost(),
                'tax' => CartService::getTax(),
                'total' => CartService::getTotal(),
            ]);
        }

        return redirect()->route('cart')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function remove(Request $request, int $id)
    {
        $result = CartService::remove($id);

        if ($request->expectsJson()) {
            return response()->json([
                ...$result,
                'subtotal' => CartService::getSubtotal(),
                'shipping' => CartService::getShippingCost(),
                'tax' => CartService::getTax(),
                'total' => CartService::getTotal(),
            ]);
        }

        return redirect()->route('cart')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
