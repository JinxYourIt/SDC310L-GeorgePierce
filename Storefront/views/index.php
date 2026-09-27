<?php
$title = 'Ol\' George\'s Market';
require_once('../controllers/store_controller.php');
$products = getProducts();
$recentOrders = getRecentOrders();
require_once('../includes/header.php');
?>

<p class="lead">From snack breaks to toolbox staples, find a little of what you need.</p>
<h2 class="h4 fw-bold border-start border-4 border-warning ps-3 mt-4 mb-3">01 / Browse the Shelves</h2>

<div class="table-responsive bg-white border rounded-3 shadow-sm mb-4">
<table class="table table-hover align-middle mb-0">
    <tr>
        <th class="text-nowrap bg-dark text-white small">Product Name</th>
        <th class="text-nowrap bg-dark text-white small">Product Description</th>
        <th class="text-nowrap bg-dark text-white small">Product Cost</th>
        <th class="text-nowrap bg-dark text-white small">Quantity in Cart</th>
        <th class="text-nowrap bg-dark text-white small">Add to Cart</th>
    </tr>
<?php
    foreach ($products as $product) {
        $id = $product['product_id'];
        $quantityInCart = 0;
        if (isset($cart[$id])) {
            $quantityInCart = $cart[$id];
        }

        echo '<tr>';
        echo '<td>' . $product['product_name'] . '</td>';
        echo '<td>' . $product['description'] . '</td>';
        echo '<td>$' . number_format($product['price'], 2) . '</td>';
        echo '<td><span class="badge rounded-pill bg-dark text-warning">' . $quantityInCart . '</span></td>';
        echo '<td>';
        echo '<form method="POST" action="index.php" class="mb-3">';
        foreach ($cart as $cartId => $cartQuantity) {
            echo '<input type="hidden" name="cart[' . $cartId . ']" value="' . $cartQuantity . '">';
        }
        echo '<input class="form-control form-control-sm" type="number" name="quantity" value="1" min="0" step="1" required aria-label="Quantity to add">';
        echo '<button class="btn btn-dark btn-sm text-nowrap mt-2" type="submit" name="add" value="' . $id . '">Add to Cart</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
?>
</table>
</div>

<?php if (count($products) == 0): ?>
    <p>The shelves are taking a breather. Please check back soon.</p>
<?php endif; ?>

<h2 class="h4 fw-bold border-start border-4 border-warning ps-3 mt-5 mb-3">02 / Cart View</h2>
<?php if (count($items) == 0): ?>
    <p class="bg-white border rounded-3 p-4 text-secondary">Your cart is waiting for its first find. Pick something from the shelves above!</p>
    <form method="POST" action="cart.php">
        <input class="btn btn-warning fw-semibold" type="submit" name="view_cart" value="View Cart">
    </form>
<?php else: ?>
    <p>Here are your picks so far. Want a little more? Add another quantity above, or remove anything you no longer need.</p>
    <form method="POST" action="index.php" class="mb-3">
        <div class="table-responsive bg-white border rounded-3 shadow-sm mb-4">
<table class="table table-hover align-middle mb-0">
            <tr>
                <th class="text-nowrap bg-dark text-white small">Product Name</th>
                <th class="text-nowrap bg-dark text-white small">Quantity in Cart</th>
                <th class="text-nowrap bg-dark text-white small">Product Cost</th>
                <th class="text-nowrap bg-dark text-white small">Product Total</th>
                <th class="text-nowrap bg-dark text-white small">Action</th>
            </tr>
            <?php
    foreach ($items as $item) {
        echo '<tr>';
        echo '<td>' . $item['product_name'] . '</td>';
        echo '<td>' . $item['quantity'];
        echo '<input type="hidden" name="cart[' . $item['product_id'] . ']" value="' . $item['quantity'] . '">';
        echo '</td>';
        echo '<td>$' . number_format($item['price'], 2) . '</td>';
        echo '<td>$' . number_format($item['price'] * $item['quantity'], 2) . '</td>';
        echo '<td><button class="btn btn-outline-danger btn-sm" type="submit" name="remove" value="' . $item['product_id'] . '">Remove from Cart</button></td>';
        echo '</tr>';
    }
?>
        </table>
</div>
        <p>
            <input class="btn btn-warning fw-semibold" type="submit" name="view_cart" value="Review Your Order" formaction="cart.php">
        </p>
    </form>
<?php endif; ?>

<h2 class="h4 fw-bold border-start border-4 border-warning ps-3 mt-5 mb-3">03 / Fresh from the Checkout</h2>
<?php if (count($recentOrders) == 0): ?>
    <p class="text-secondary">No orders yet. Your next find could start the list!</p>
<?php else: ?>
    <div class="table-responsive bg-white border rounded-3 shadow-sm mb-4">
<table class="table table-hover align-middle mb-0">
        <tr>
            <th class="text-nowrap bg-dark text-white small">Order ID</th>
            <th class="text-nowrap bg-dark text-white small">Order Date</th>
            <th class="text-nowrap bg-dark text-white small">Status</th>
            <th class="text-nowrap bg-dark text-white small">Order Total</th>
        </tr>
        <?php
    foreach ($recentOrders as $order) {
        echo '<tr>';
        echo '<td>' . $order['order_id'] . '</td>';
        echo '<td>' . $order['order_date'] . '</td>';
        echo '<td>' . $order['status'] . '</td>';
        echo '<td>$' . number_format($order['total_amount'], 2) . '</td>';
        echo '</tr>';
    }
?>
    </table>
</div>
<?php endif; ?>

<?php require_once('../includes/footer.php'); ?>
