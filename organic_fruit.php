<?php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'organic_food');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch products only from the 'fruits' category
$result = $conn->query("SELECT * FROM products WHERE category = 'fruits'");

// Handle Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_query = $conn->query("SELECT * FROM products WHERE id = '$product_id'");
    $product = $product_query->fetch_assoc();
    
    if ($product) {
        $cart_item = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }
    }
}

// Handle Buy Now functionality
if (isset($_POST['buy_now'])) {
    $product_id = $_POST['product_id'];
    $_SESSION['cart'] = [];
    
    $product_query = $conn->query("SELECT * FROM products WHERE id = '$product_id'");
    $product = $product_query->fetch_assoc();
    
    if ($product) {
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
    }
    
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Organic Fruits</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .product-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 250px;
            background: #f9f9f9;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1 class="text-center text-success">Organic Fruits</h1>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Organix Logo" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active text-success" href="vegetables.php">Organic Vegetables</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">🛒 Cart</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php">👤 Profile</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">🔒 Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <!-- Display Fruits -->
    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item card">
                <img class="card-img-top" src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $row['name']; ?> </h5>
                    <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
                        <button type="submit" name="buy_now" class="btn btn-primary">Buy Now</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
