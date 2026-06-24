<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$user_id = $_SESSION['user_id'];
$listing_id = (int)$_GET['id'];
$check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id=$user_id AND listing_id=$listing_id");
if (mysqli_num_rows($check) == 0) {
  mysqli_query($conn, "INSERT INTO wishlist (user_id, listing_id) VALUES ($user_id, $listing_id)");
}
header('Location: index.php');
exit();
?>
