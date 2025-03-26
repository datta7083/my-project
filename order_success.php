<?php
session_start();
require_once 'config.php';

if (!isset($_GET['order_id'])) {
    die("Invalid order. Please try again.");
}

$order_id = htmlspecialchars($_GET['order_id']);

// Handle rating form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $feedback = isset($_POST['feedback']) ? htmlspecialchars($_POST['feedback']) : '';

    if ($rating !== null && $rating > 0 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO ratings (order_id, rating, feedback) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $order_id, $rating, $feedback);
        if ($stmt->execute()) {
            $success_message = "Thank you for your feedback!";
        } else {
            $error_message = "Failed to submit feedback. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "Please select a valid rating.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="success-container">
        <h2>Thank You for Your Order!</h2>
        <p>Your order ID is: <strong>#<?php echo $order_id; ?></strong></p>
        <a href="index.php">Return to Home</a>

        <hr>

        <h3>Rate Your Experience</h3>

        <?php if (isset($success_message)) echo "<p class='success'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>

        <form method="post">
            <label for="rating">Select Rating:</label>
            <select name="rating" id="rating" required>
                <option value="">Choose</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Very Bad</option>
            </select>

            <label for="feedback">Your Feedback:</label>
            <textarea name="feedback" id="feedback" rows="4" placeholder="Share your experience..." required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .success-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        width: 90%;
    }

    h2 {
        color: #28a745;
        margin-bottom: 15px;
    }

    p {
        font-size: 18px;
        color: #333;
    }

    a {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    a:hover {
        background-color: #0056b3;
    }

    form {
        margin-top: 20px;
        text-align: left;
    }

    label {
        display: block;
        font-weight: bold;
        margin: 10px 0 5px;
    }

    select, textarea, button {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
    }

    button {
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background-color: #218838;
    }

    .success {
        color: green;
        font-weight: bold;
    }

    .error {
        color: red;
        font-weight: bold;
    }
</style>
</html>
