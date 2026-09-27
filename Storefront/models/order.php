<?php

require_once('database.php');
require_once('product.php');


// create an order record
function createOrder($totalAmount){
    $conn = connect_db();
    $sql = "INSERT INTO orders(status, total_amount) VALUES('Pending', ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "d", $totalAmount);

    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($conn);
}

// add an order item record derived from an order made on the application
function addOrderItem($orderId, $productId, $quantity, $unitPrice){
    $conn = connect_db();
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiid", $orderId, $productId, $quantity, $unitPrice);

    mysqli_stmt_execute($stmt);
}

// update an orders status (to signify in progress or completion)
function updateOrderStatus($orderId, $status){
    $conn = connect_db();
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $status, $orderId);

    mysqli_stmt_execute($stmt);
}

function getRecentOrders() {
    $conn = connect_db();
    $sql = 'SELECT * FROM orders ORDER BY order_date DESC, order_id DESC LIMIT 10';
    $result = mysqli_query($conn, $sql);
    $orders = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

// Create the order and its items, then reduce the quantities in stock.
function processOrder($items, $total) {
    $orderId = createOrder($total);
    foreach ($items as $item) {
        addOrderItem($orderId, $item['product_id'], $item['quantity'], $item['price']);
        updateProductStock($item['product_id'], -$item['quantity']);
    }
    updateOrderStatus($orderId, 'Completed');
    return $orderId;
}
