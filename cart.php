<?php
session_start();

// Initialize total price
$total = 0;

// Handle cart clearing
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

// Handle product removal
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset array keys
            header("Location: cart.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Your Shopping Cart</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (per kg)</th>
                    <th>Quantity (kg)</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $index => $item): 
                        // Extract numeric quantity value
                        $quantity = isset($item['quantity']) ? (float) filter_var($item['quantity'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 1;
                        $subtotal = $item['price'] * $quantity;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" width="50"> <?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $quantity; ?> kg</td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td><a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-danger">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="cart.php?action=clear" class="btn btn-warning">Clear Cart</a>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>

        <?php if (!empty($_SESSION['cart'])): ?>
            <a href="checkout.php" class="btn btn-success float-end">Buy Now / Checkout</a>
        <?php endif; ?>
    </div>
</body>
</html>
