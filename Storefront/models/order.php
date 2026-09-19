<?php

// create an order record
function createOrder($conn, $totalAmount){
    $sql = "INSERT INTO orders(status, total_amount) VALUES('Pending', ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "d", $totalAmount);

    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($conn);
}

// add an order item record derived from an order made on the application
function addOrderItem($conn, $orderId, $productId, $quantity, $unitPrice){
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiid", $orderId, $productId, $quantity, $unitPrice);

    return mysqli_stmt_execute($stmt);
}

// get an order record by its id
function getOrderById($conn, $sql){
    $sql = "SELECT * FROM orders WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $orderId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// get all items of an order
function getOrderItems($conn, $orderId){
    $sql = "SELECT * FROM order_items WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $orderId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $orderItems = [];

    while ($row = mysqli_fetch_array($result)){
        $orderItems[] = $row;
    }
    return $orderItems;
}

// delete an order (in the event of cancellation)
function deleteOrder($conn, $orderId){
    $sql = "DELETE FROM orders WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $orderId);

    return mysqli_stmt_execute($stmt);
}

// update an orders status (to signify in progress or completion)
function updateOrderStatus($conn, $orderId, $status){
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $status, $orderId);

    return mysqli_stmt_execute($stmt);
}