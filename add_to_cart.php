<?php
session_start();

// Validate product data
if (!isset($_POST['id'], $_POST['name'], $_POST['price'], $_POST['image'])) {
    die("Invalid product data.");
}

// Get product data
$product = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'image' => $_POST['image'],
    'quantity' => 1 // Default quantity set to 1
];

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if product already exists in cart, increase quantity
$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $product['id']) {
        $item['quantity'] += 1; // Increase quantity if product already in cart
        $found = true;
        break;
    }
}

// If product is new, add to cart
if (!$found) {
    $_SESSION['cart'][] = $product;
}

// Redirect to cart page
header("Location: cart.php");
exit();
?>
<?php if (isset($_SESSION['user_id'])): ?>
    <form action="submit_rating.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
        <label for="rating">Rate this product:</label>
        <select name="rating" class="form-select" required>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
        </select>
        <button type="submit" class="btn btn-warning mt-2">Submit Rating</button>
    </form>
<?php else: ?>
    <p class="text-muted">Login to rate this product.</p>
<?php endif; ?>
