<?php

// Keep only positive product IDs and positive whole-number quantities.
function readCart($input) {
    $cart = array();
    if (!is_array($input)) {
        return $cart;
    }

    // Each entry contains a product ID and its ordered quantity.
    foreach ($input as $productId => $quantity) {
        $productId = filter_var($productId, FILTER_VALIDATE_INT);
        $quantity = filter_var($quantity, FILTER_VALIDATE_INT);

        if ($productId > 0 && $quantity > 0) {
            $cart[$productId] = $quantity;
        }
    }
    return $cart;
}

function orderTotals($items) {
    $quantity = 0;
    $subtotal = 0;

    foreach ($items as $item) {
        $productTotal = $item['price'] * $item['quantity'];
        $subtotal = $subtotal + $productTotal;
        $quantity = $quantity + $item['quantity'];
    }

    $subtotal = round($subtotal, 2);
    $tax = round($subtotal * 0.05, 2);
    $shipping = round($subtotal * 0.10, 2);
    $total = round($subtotal + $tax + $shipping, 2);

    // Put the finished calculations together for the cart page.
    $totals = array();
    $totals['quantity'] = $quantity;
    $totals['subtotal'] = $subtotal;
    $totals['tax'] = $tax;
    $totals['shipping'] = $shipping;
    $totals['total'] = $total;
    return $totals;
}
