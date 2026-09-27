<?php
require_once('../models/product.php');
require_once('../models/order.php');
require_once('../includes/functions.php');

// Match each posted quantity with the product information in the database.
function getCartItems($cart) {
    $items = array();
    foreach ($cart as $id => $quantity) {
        $product = getProductById($id);
        if ($product) {
            $product['quantity'] = $quantity;
            $items[] = $product;
        }
    }
    return $items;
}

$cart = array();
$error = '';

if (isset($_POST['cart'])) {
    $cart = readCart($_POST['cart']);
}

// The clicked button supplies the product ID.
if (isset($_POST['add'])) {
    $id = (int) $_POST['add'];
    $quantity = 0;
    if (isset($_POST['quantity'])) {
        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
    }
    if ($quantity > 0 && getProductById($id)) {
        if (isset($cart[$id])) {
            $cart[$id] = $cart[$id] + $quantity;
        } else {
            $cart[$id] = $quantity;
        }
    }
} else if (isset($_POST['remove'])) {
    $id = (int) $_POST['remove'];
    unset($cart[$id]);
}

$items = getCartItems($cart);
$totals = orderTotals($items);

if (isset($_POST['checkout'])) {
    // Check every product before making any database changes.
    if (count($cart) == 0) {
        $error = 'Add a product before checking out.';
    } else if (count($items) != count($cart)) {
        $error = 'A product is no longer available. Return to the catalog to update your cart.';
    }

    foreach ($items as $item) {
        if ($item['quantity'] > $item['stock_quant']) {
            $error = 'Not enough stock for ' . $item['product_name'] . '. Available: ' . $item['stock_quant'] . '.';
        }
    }

    if ($error == '') {
        processOrder($items, $totals['total']);
        $cart = array();
        header('Location: index.php', true, 303);
        exit;
    }
}
