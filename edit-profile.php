<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user details
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);

    // Check if the email is already in use by another user
    $email_check_stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
    $email_check_stmt->bind_param("si", $new_email, $user_id);
    $email_check_stmt->execute();
    $email_check_stmt->bind_result($email_count);
    $email_check_stmt->fetch();
    $email_check_stmt->close();

    if ($email_count > 0) {
        $error = "Email already in use. Please choose another.";
    } else {
        // Update user details
        $update_stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $new_name, $new_email, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php");
            exit();
        } else {
            $error = "Update failed!";
        }
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Organix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

        .btn {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="edit-profile.php" method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <button type="submit">Update Profile</button>
        </form>
        <a href="profile.php" class="btn">Back to Profile</a>
    </div>
</body>
</html>
