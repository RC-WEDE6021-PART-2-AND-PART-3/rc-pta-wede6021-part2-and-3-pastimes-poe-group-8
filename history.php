<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$user_id = $_SESSION['user_id'];
$orders = mysqli_query($conn, "SELECT o.*, l.item_name, l.brand, l.price, l.size, u.username as seller FROM orders o JOIN listings l ON o.listing_id = l.listing_id JOIN tblUser u ON l.seller_id = u.user_id WHERE o.buyer_id = $user_id ORDER BY o.order_date DESC");
$total = 0;
?>
<!DOCTYPE html><html><head><title>Order History - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:28px;font-weight:700;margin-bottom:24px;'>Your Purchase History</h1>
  <table>
    <tr><th>Item</th><th>Brand</th><th>Size</th><th>Seller</th><th>Date</th><th>Price</th><th>Status</th></tr>
    <?php while($o = mysqli_fetch_assoc($orders)): $total += $o['price']; ?>
    <tr>
      <td><?php echo $o['item_name']; ?></td>
      <td><?php echo $o['brand']; ?></td>
      <td><?php echo $o['size']; ?></td>
      <td>@<?php echo $o['seller']; ?></td>
      <td><?php echo date('d M Y', strtotime($o['order_date'])); ?></td>
      <td>R<?php echo $o['price']; ?></td>
      <td><span class='badge-pending'><?php echo ucfirst($o['status']); ?></span></td>
    </tr>
    <?php endwhile; ?>
    <tr style='font-weight:700;border-top:2px solid #333;'>
      <td colspan='5'>TOTAL</td>
      <td>R<?php echo $total; ?></td>
      <td></td>
    </tr>
  </table>
</div>
</body></html>
