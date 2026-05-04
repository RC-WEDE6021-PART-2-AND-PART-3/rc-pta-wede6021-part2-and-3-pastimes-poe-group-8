<?php
include 'DbConnect.php';

// Create delivery_details table
mysqli_query($conn, "CREATE TABLE delivery_details (
    delivery_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    address_line1 VARCHAR(150),
    address_line2 VARCHAR(150),
    city VARCHAR(50),
    province VARCHAR(50),
    postal_code VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES tbluser(user_id)
)");

// Create listings table
mysqli_query($conn, "CREATE TABLE listings (
    listing_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    item_name VARCHAR(100),
    brand VARCHAR(50),
    size VARCHAR(20),
    condition_desc VARCHAR(255),
    price DECIMAL(10,2),
    image_path VARCHAR(255),
    is_sold TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES tbluser(user_id)
)");

// Create wishlist table
mysqli_query($conn, "CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    listing_id INT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbluser(user_id),
    FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
)");

// Create cart table
mysqli_query($conn, "CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    listing_id INT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbluser(user_id),
    FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
)");

// Create orders table
mysqli_query($conn, "CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    listing_id INT,
    delivery_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','delivered') DEFAULT 'pending',
    FOREIGN KEY (buyer_id) REFERENCES tbluser(user_id),
    FOREIGN KEY (listing_id) REFERENCES listings(listing_id),
    FOREIGN KEY (delivery_id) REFERENCES delivery_details(delivery_id)
)");

// Create messages table
mysqli_query($conn, "CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    listing_id INT,
    message_text TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES tbluser(user_id),
    FOREIGN KEY (receiver_id) REFERENCES tbluser(user_id),
    FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
)");

echo "All tables created successfully!";
?>


