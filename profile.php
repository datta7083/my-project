<?php
session_start();
include 'config.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Fetch purchased products
$orders = [];
$order_stmt = $conn->prepare("
    SELECT products.name, products.price, orders.order_date 
    FROM orders 
    JOIN order_items ON orders.id = order_items.order_id 
    JOIN products ON order_items.product_id = products.id 
    WHERE orders.user_id = ?
");
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

while ($row = $order_result->fetch_assoc()) {
    $orders[] = $row;
}

$order_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Organic</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        /* Navigation Bar Styles */
        .navbar {
            background-color: #2e7d32; /* Dark Green */
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-size: 1.1rem;
            margin-right: 15px;
            transition: 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: #c8e6c9 !important; /* Light Green Hover */
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid white;
        }

        .navbar-toggler {
            border-color: white;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Organix</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="container mt-4">
        <div class="profile-container card p-4 shadow">
            <h2 class="text-center">User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>

            <h3 class="mt-4">Purchased Products</h3>
            <?php if (count($orders) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($orders as $order): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($order['name']); ?> - 
                            $<?php echo number_format($order['price'], 2); ?> 
                            <small class="text-muted">(Purchased on <?php echo $order['order_date']; ?>)</small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No purchases yet.</p>
            <?php endif; ?>
            
            <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
