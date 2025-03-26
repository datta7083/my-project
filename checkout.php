<?php
session_start();
include_once(__DIR__ . '/config.php'); // Ensure correct path

// Check if database connection is set
if (!isset($conn)) {
    die("Database connection failed. Please check config.php.");
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_data = [];
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$query = $stmt->get_result();
if ($query->num_rows > 0) {
    $user_data = $query->fetch_assoc();
}
$stmt->close();

// Initialize total price
$total_price = 0;

// Calculate total price from the cart
foreach ($_SESSION['cart'] as $item) {
    $quantity = isset($item['quantity']) ? (float) filter_var($item['quantity'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 1;
    $price = isset($item['price']) ? (float) $item['price'] : 0;
    $total_price += $price * $quantity;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $payment_method = trim($_POST['payment_method']);
    $status = "Pending"; // Default status for new orders

    // Insert order into `orders` table
    $order_query = $conn->prepare("INSERT INTO orders (user_id, name, email, address, total_price, payment_method, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $order_query->bind_param("isssdss", $user_id, $name, $email, $address, $total_price, $payment_method, $status);

    if ($order_query->execute()) {
        $order_id = $order_query->insert_id;
        $order_query->close();

        // Insert order items into `order_items` table
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $item_query = $conn->prepare($sql);

        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity = (float) filter_var($item['quantity'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $price = (float) $item['price'];

            $item_query->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $item_query->execute();
        }

        $item_query->close();

        // Clear cart after successful order
        unset($_SESSION['cart']);
        header("Location: order_success.php?order_id=$order_id");
        exit();
    } else {
        echo "<p>Error placing order. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
            
            <label>Address:</label>
            <textarea name="address" required></textarea>
            
            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="COD">Cash on Delivery</option>
                <option value="Card">Credit/Debit Card</option>
                <option value="PayPal">PayPal</option>
            </select>
            
            <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
            <button type="submit">Place Order</button>
        </form>
        <a href="cart.php">Back to Cart</a>
    </div>
</body>
</html>
