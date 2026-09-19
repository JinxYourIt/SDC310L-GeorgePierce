<?php

// get active products
function getProducts($conn){
    $sql = "SELECT * FROM products WHERE is_active = TRUE";
    $result = mysqli_query($conn, $sql);

    $products = [];

    while ($row = mysqli_fetch_array($result)){
        $products[] = $row;
    }
    return $products;
}

// get a product record by its id
function getProductById($conn, $id){
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

// update stock_quant value
function updateProductStock($conn, $id, $quant){
    $sql = "UPDATE products SET stock_quant = stock_quant + ? WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $quant, $id);
    return mysqli_stmt_execute($stmt);
}

// show out of stock products
function getInactiveProducts($conn){
    $sql = "SELECT * FROM products WHERE is_active = FALSE";

    $result = mysqli_query($conn, $sql);

    $products = [];

    while ($row = mysqli_fetch_array($result)){
        $products[] = $row;
    }
    return $products;
}
?>