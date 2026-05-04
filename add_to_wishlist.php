// wishlist
<?php
include 'DbConnect.php';
session_start();

$user_id = $_SESSION['user_id'];
$listing_id = $_GET['id'];

mysqli_query($conn, "INSERT INTO wishlist (user_id, listing_id) VALUES ($user_id, $listing_id)");

header("Location: index.php");
?>