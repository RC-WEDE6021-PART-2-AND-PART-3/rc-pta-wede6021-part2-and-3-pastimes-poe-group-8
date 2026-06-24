<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }

$listing_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if item already in cart
$check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND listing_id=$listing_id");
if (mysqli_num_rows($check) > 0) {
  // Increase quantity
  mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND listing_id=$listing_id");
} else {
  // Add new item
  mysqli_query($conn, "INSERT INTO cart (user_id, listing_id, quantity) VALUES ($user_id, $listing_id, 1)");
}
header('Location: index.php');
exit();
?>
