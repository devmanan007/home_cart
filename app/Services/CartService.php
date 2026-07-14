<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const CART_KEY = 'cart';

    public static function getCart(): array
    {
        return Session::get(self::CART_KEY, []);
    }

    public static function add(int $productId, int $quantity = 1): array
    {
        $cart = self::getCart();

        $existingIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['product_id'] === $productId) {
                $existingIndex = $index;
                break;
            }
        }

        $product = Product::findOrFail($productId);

        if (!$product->isInStock()) {
            return ['success' => false, 'message' => 'Product is out of stock.'];
        }

        if ($existingIndex !== null) {
            $newQty = $cart[$existingIndex]['quantity'] + $quantity;
            if ($newQty > $product->stock_quantity) {
                return ['success' => false, 'message' => 'Not enough stock available. Only ' . $product->stock_quantity . ' left.'];
            }
            $cart[$existingIndex]['quantity'] = $newQty;
        } else {
            if ($quantity > $product->stock_quantity) {
                return ['success' => false, 'message' => 'Not enough stock available. Only ' . $product->stock_quantity . ' left.'];
            }
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }

        Session::put(self::CART_KEY, $cart);

        return ['success' => true, 'message' => 'Item added to cart!', 'cart_count' => self::getCount()];
    }

    public static function update(int $productId, int $quantity): array
    {
        $cart = self::getCart();

        foreach ($cart as $index => $item) {
            if ($item['product_id'] === $productId) {
                if ($quantity <= 0) {
                    unset($cart[$index]);
                    $cart = array_values($cart);
                } else {
                    $product = Product::find($productId);
                    if ($product && $quantity > $product->stock_quantity) {
                        return ['success' => false, 'message' => 'Not enough stock. Only ' . $product->stock_quantity . ' available.'];
                    }
                    $cart[$index]['quantity'] = $quantity;
                }
                Session::put(self::CART_KEY, $cart);
                return ['success' => true, 'message' => 'Cart updated.', 'cart_count' => self::getCount()];
            }
        }

        return ['success' => false, 'message' => 'Item not found in cart.'];
    }

    public static function remove(int $productId): array
    {
        $cart = self::getCart();

        foreach ($cart as $index => $item) {
            if ($item['product_id'] === $productId) {
                unset($cart[$index]);
                $cart = array_values($cart);
                Session::put(self::CART_KEY, $cart);
                return ['success' => true, 'message' => 'Item removed from cart.', 'cart_count' => self::getCount()];
            }
        }

        return ['success' => false, 'message' => 'Item not found in cart.'];
    }

    public static function clear(): void
    {
        Session::forget(self::CART_KEY);
    }

    public static function getCount(): int
    {
        $cart = self::getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    public static function getItems(): array
    {
        $cart = self::getCart();
        if (empty($cart)) {
            return [];
        }

        $productIds = array_column($cart, 'product_id');
        $products = Product::with(['category', 'primaryImage'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        foreach ($cart as $item) {
            if (isset($products[$item['product_id']])) {
                $product = $products[$item['product_id']];
                $effectivePrice = $product->getEffectivePrice();
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $effectivePrice,
                    'line_total' => $effectivePrice * $item['quantity'],
                ];
            }
        }

        return $items;
    }

    public static function getSubtotal(): float
    {
        $items = self::getItems();
        return array_sum(array_column($items, 'line_total'));
    }

    public static function getShippingCost(): float
    {
        $subtotal = self::getSubtotal();
        if ($subtotal >= 500) {
            return 0.00;
        }
        return 50.00;
    }

    public static function getTax(): float
    {
        return round(self::getSubtotal() * 0.05, 2);
    }

    public static function getTotal(): float
    {
        return self::getSubtotal() + self::getShippingCost() + self::getTax();
    }
}
