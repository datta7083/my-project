<?php
require 'config.php'; // Include database connection

$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $successMessage = "Thank you for contacting us. We will get back to you soon!";
        } else {
            $errorMessage = "Something went wrong. Please try again.";
        }
    } else {
        $errorMessage = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    text-align: center;
}

h2 {
    color: #28a745;
    margin-top: 20px;
}

form {
    background: white;
    max-width: 500px;
    margin: 20px auto;
    padding: 50px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
    border-radius: 5px;
    transition: background 0.3s;
}

button:hover {
    background: #218838;
}

.success {
    color: green;
}

.error {
    color: red;
}

    </style>
</head>
<body>

    <h2>Contact Us</h2>

    <?php if ($successMessage): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Message:</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit">Send Message</button>
    </form>

</body>
</html>
