<?php
/*
George Pierce
SDC310L
Catalog Project
*/

// Run from the tests folder: php storefront_test.php
require_once('../models/order.php');
$conn = connect_db();

function check($condition, $message) {
    if (!$condition) {
        echo 'FAIL: ' . $message . PHP_EOL;
        exit(1);
    }
}

// Temporary tables exist only for this connection. Real records are unchanged.
mysqli_query($conn, 'CREATE TEMPORARY TABLE products (
    product_id INT PRIMARY KEY, product_name VARCHAR(150), description VARCHAR(150),
    price DECIMAL(10,2), stock_quant INT NOT NULL) ENGINE=InnoDB');
mysqli_query($conn, 'CREATE TEMPORARY TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY, order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(30), total_amount DECIMAL(10,2)) ENGINE=InnoDB');
mysqli_query($conn, 'CREATE TEMPORARY TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY, order_id INT, product_id INT,
    quantity INT, unit_price DECIMAL(10,2)) ENGINE=InnoDB');
mysqli_query($conn, "INSERT INTO products VALUES
    (1, 'Test A', 'First product', 10.00, 10),
    (2, 'Test B', 'Second product', 20.00, 10),
    (3, 'Test C', 'Third product', 0.99, 10),
    (4, 'Test D', 'Fourth product', 40.00, 10),
    (5, 'Test E', 'Fifth product', 50.00, 0)");

$_POST = array();
require_once('../controllers/store_controller.php');

check(count(getProducts()) == 5, 'Catalog includes all five products.');
check(readCart(array(1 => '0', 2 => '3')) == array(2 => 3), 'Zero quantities are removed.');
check(readCart(array(1 => -1, 2 => '1.5', 3 => 'bad', 4 => array())) == array(), 'Invalid quantities are removed.');
check(readCart('bad') == array(), 'Invalid cart becomes empty.');
$items = getCartItems(array(1 => 2, 2 => 1));
$totals = orderTotals($items);
check($totals['subtotal'] == 40 && $totals['tax'] == 2 && $totals['shipping'] == 4 && $totals['total'] == 46, 'Order totals.');
check($totals['quantity'] == 3, 'Total quantity.');
check(orderTotals(getCartItems(array(3 => 1)))['total'] == 1.14, 'Round tax and shipping to cents.');
check(orderTotals(array())['total'] == 0, 'Empty cart total.');

$orderId = processOrder($items, $totals['total']);
check($orderId > 0, 'Checkout creates an order.');
$savedOrder = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT * FROM orders WHERE order_id = ' . (int) $orderId));
check($savedOrder['total_amount'] == 46, 'Saved order total.');
check($savedOrder['status'] == 'Completed', 'Completed status.');
$savedItems = mysqli_query($conn, 'SELECT * FROM order_items WHERE order_id = ' . (int) $orderId);
check(mysqli_num_rows($savedItems) == 2, 'Two order items.');
check(getProductById(1)['stock_quant'] == 8 && getProductById(2)['stock_quant'] == 9, 'Inventory decreases.');
check(count(getRecentOrders()) == 1, 'Recent orders includes checkout.');

echo 'PASS: catalog, quantities, totals, order records, inventory, and recent orders.' . PHP_EOL;
