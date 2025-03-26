<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Organic Food</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background: #28a745;
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 85%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            display: flex;
        }

        .nav-links li {
            margin-left: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #ffcc00;
        }

        /* Sections Styling */
        .section {
            text-align: center;
            padding: 80px 40px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: 60px auto;
            border-radius: 15px;
        }

        .section h2 {
            color: #28a745;
            font-size: 38px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section p {
            font-size: 18px;
            color: #555;
            line-height: 1.8;
            max-width: 900px;
            margin: 15px auto;
        }

        .developer {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 20px;
        }

        .developer-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
        }

        .developer-card strong {
            display: block;
            font-size: 20px;
            color: #28a745;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Organic Food</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- About Us Section -->
    <section class="section">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to Organic Food, your trusted source for fresh, organic, and healthy products. Our mission is to bring you the best organic foods sourced directly from farmers and trusted suppliers.</p>
            <p>We believe in sustainability, health, and supporting local farmers. Our commitment to quality ensures that you get 100% natural and organic products delivered to your doorstep.</p>
            <p>Thank you for choosing Organic Food – where health meets nature.</p>
        </div>
    </section>

    <!-- Developers Section -->
    <section class="section">
        <div class="container">
            <h2>Meet the Developers</h2>
            <p>Our talented team of developers worked tirelessly to create this platform to serve our customers better.</p>
            <div class="developer">
                <div class="developer-card">
                    <strong>John Doe</strong>
                    <p>Lead Developer</p>
                </div>
                <div class="developer-card">
                    <strong>Jane Smith</strong>
                    <p>UI/UX Designer</p>
                </div>
                <div class="developer-card">
                    <strong>Mike Johnson</strong>
                    <p>Backend Engineer</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>