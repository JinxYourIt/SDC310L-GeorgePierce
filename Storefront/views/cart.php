<?php
$title = 'Your Cornerstone Cart';
require_once('../controllers/store_controller.php');
require_once('../includes/header.php');
?>

<?php if (count($items) == 0): ?>
    <p>Nothing in your cart just yet. Head back to the shelves and find your favorites.</p>
<?php else: ?>
    <p>One last look at your picks before you place your order.</p>
    <div class="table-responsive bg-white border rounded-3 shadow-sm mb-4">
<table class="table table-hover align-middle mb-0">
        <tr>
            <th class="text-nowrap bg-dark text-white small">Product Name</th>
            <th class="text-nowrap bg-dark text-white small">Quantity Ordered</th>
            <th class="text-nowrap bg-dark text-white small">Product Cost</th>
            <th class="text-nowrap bg-dark text-white small">Product Total</th>
        </tr>
        <?php
    foreach ($items as $item) {
        echo '<tr>';
        echo '<td>' . $item['product_name'] . '</td>';
        echo '<td>' . $item['quantity'] . '</td>';
        echo '<td>$' . number_format($item['price'], 2) . '</td>';
        echo '<td>$' . number_format($item['price'] * $item['quantity'], 2) . '</td>';
        echo '</tr>';
    }
?>
    </table>
</div>
<?php endif; ?>

<h2 class="h4 fw-bold border-start border-4 border-warning ps-3 mt-4 mb-3">Your Order at a Glance</h2>
<div class="table-responsive bg-white border rounded-3 shadow-sm mb-4">
<table class="table table-hover align-middle mb-0">
    <tr>
        <th class="text-nowrap bg-dark text-white small">Items in Your Cart</th>
        <?php echo '<td>' . $totals['quantity'] . '</td>'; ?>
    </tr>
    <tr>
        <th class="text-nowrap bg-dark text-white small">Item Subtotal</th>
        <?php echo '<td>$' . number_format($totals['subtotal'], 2) . '</td>'; ?>
    </tr>
    <tr>
        <th class="text-nowrap bg-dark text-white small">Tax (5%)</th>
        <?php echo '<td>$' . number_format($totals['tax'], 2) . '</td>'; ?>
    </tr>
    <tr>
        <th class="text-nowrap bg-dark text-white small">Shipping &amp; Handling (10%)</th>
        <?php echo '<td>$' . number_format($totals['shipping'], 2) . '</td>'; ?>
    </tr>
    <tr>
        <th class="bg-warning text-dark fs-5">Order Total</th>
        <?php echo '<td>$' . number_format($totals['total'], 2) . '</td>'; ?>
    </tr>
</table>
</div>

<form method="POST" action="index.php" class="d-inline-block me-2 mb-3">
    <?php
    foreach ($cart as $id => $quantity) {
        echo '<input type="hidden" name="cart[' . $id . ']" value="' . $quantity . '">';
    }
?>
    <input class="btn btn-outline-dark" type="submit" name="continue" value="Back to the Shelves">
</form>

<?php if (count($items) > 0): ?>
    <form method="POST" action="cart.php" class="d-inline-block mb-3">
        <?php
    foreach ($cart as $id => $quantity) {
        echo '<input type="hidden" name="cart[' . $id . ']" value="' . $quantity . '">';
    }
?>
        <input class="btn btn-warning fw-semibold" type="submit" name="checkout" value="Place Order">
    </form>
<?php endif; ?>

<?php require_once('../includes/footer.php'); ?>
