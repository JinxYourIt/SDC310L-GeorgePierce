<?php

require_once('database.php');

// List the catalog, including products currently out of stock.
function getProducts(){
    $conn = connect_db();
    $sql = "SELECT * FROM products ORDER BY product_id";
    $result = mysqli_query($conn, $sql);

    $products = array();

    while ($row = mysqli_fetch_assoc($result)){
        $products[] = $row;
    }
    return $products;
}

// get a product record by its id
function getProductById($id){
    $conn = connect_db();
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// Update stock after the controller has checked availability.
function updateProductStock($id, $quant){
    $conn = connect_db();
    $sql = "UPDATE products SET stock_quant = stock_quant + ? WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $quant, $id);
    mysqli_stmt_execute($stmt);
}
