CREATE DATABASE organic_food;
USE organic_food;

/* Users Table */
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
ALTER TABLE users ADD COLUMN phone VARCHAR(20) NOT NULL;


/* Products Table */
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description VARCHAR(255),
    image VARCHAR(255),
    category VARCHAR(255) NOT NULL
);

/* Admin Table */
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES 
('admin', 'admin123')
ON DUPLICATE KEY UPDATE username=username;

UPDATE admin SET password = '$2y$10$JwPXp3/JZQeEfOnUhlAeXePQQ6mB2k4BCso0QJm7N3yNsGBhWXXae' WHERE username = 'admin';



/* Orders Table */
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2) NOT NULL,
    order_status ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
ALTER TABLE orders ADD COLUMN name VARCHAR(255) NOT NULL;
ALTER TABLE orders ADD COLUMN email VARCHAR(255) NOT NULL;
ALTER TABLE orders ADD COLUMN address TEXT NOT NULL;
ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50) NOT NULL;
ALTER TABLE orders ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Pending';


/* Order Items Table */
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
ALTER TABLE order_items ADD COLUMN product_name VARCHAR(255) NOT NULL;
ALTER TABLE order_items ADD COLUMN price DECIMAL(10,2) NOT NULL;
ALTER TABLE order_items ADD COLUMN name VARCHAR(255) NOT NULL;


/* Insert Default Admin User (Password is "admin123") */
INSERT INTO admin (username, password) VALUES 
('admin', 'admin123')
ON DUPLICATE KEY UPDATE username=username;
CREATE TABLE imported_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    origin VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


/* Sample Products */
INSERT INTO products (name, price, description, image, category) VALUES
('Organic Carrot', 2.99, 'Fresh organic carrots', 'carrot.jpg', 'organic_vegetable'),
('Organic Tomato', 3.49, 'Ripe organic tomatoes', 'tomato.jpg', 'organic_vegetable'),
('Organic Spinach', 1.99, 'Healthy organic spinach', 'spinach.jpg', 'organic_vegetable');

/* Sample Users */
INSERT INTO users (name, email, password) VALUES
('John Doe', 'john@example.com', '$2y$10$WzXbcQ6NcP.1cQehF5E14.G1sn1PtfYX.7ZZekMdBEsSxUyXZ9aF6'),
('Jane Smith', 'jane@example.com', '$2y$10$Kz3sO/UuYOTMWsl0wJ.s6u.yt3X/tY82vWZdxiSklo0R1O69d/WeG');



CREATE TABLE fruits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);


CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
