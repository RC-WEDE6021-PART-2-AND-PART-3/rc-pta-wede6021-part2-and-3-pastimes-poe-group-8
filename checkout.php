<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$user_id = $_SESSION['user_id'];

// Generate order reference
$orderNum = 'ORD-' . strtoupper(uniqid());
$sessionId = session_id();

// Get cart items
$cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");

while ($item = mysqli_fetch_assoc($cart)) {
  $listing_id = $item['listing_id'];
  mysqli_query($conn, "INSERT INTO orders (buyer_id, listing_id, order_date, status) VALUES ($user_id, $listing_id, NOW(), 'pending')");
  mysqli_query($conn, "UPDATE listings SET is_sold=1 WHERE listing_id=$listing_id");
}

// Empty cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");

?>
<!DOCTYPE html><html><head><title>Checkout - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container' style='max-width:600px;margin:80px auto;text-align:center;'>
  <div style='font-size:60px;margin-bottom:16px;'>&#10003;</div>
  <h1 style='font-size:28px;font-weight:700;margin-bottom:12px;'>Order Confirmed!</h1>
  <p style='color:#666;margin-bottom:24px;'>Thank you for your purchase. Your order has been placed.</p>
  <div class='card' style='text-align:left;'>
    <p><strong>Order Reference:</strong> <?php echo $orderNum; ?></p>
    <p><strong>Session ID:</strong> <?php echo $sessionId; ?></p>
  </div>
  <div style='margin-top:24px;display:flex;gap:12px;justify-content:center;'>
    <a href='index.php' class='btn-secondary' style='text-decoration:none;padding:12px 24px;'>Continue Shopping</a>
    <a href='history.php' class='btn-primary' style='text-decoration:none;padding:12px 24px;'>View Order History</a>
  </div>
</div>
</body>
</html>
