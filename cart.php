<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$user_id = $_SESSION['user_id'];

// Remove item
if (isset($_GET['remove'])) {
  $rid = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM cart WHERE cart_id=$rid AND user_id=$user_id");
  header('Location: cart.php'); exit();
}
$cart = mysqli_query($conn, "SELECT c.*, l.item_name, l.brand, l.price, l.size, l.image_path, u.username as seller FROM cart c JOIN listings l ON c.listing_id = l.listing_id JOIN tblUser u ON l.seller_id = u.user_id WHERE c.user_id = $user_id");
$subtotal = 0;
$shipping = 10;
?>
<!DOCTYPE html><html><head><title>Cart - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:28px;font-weight:700;margin-bottom:24px;'>Shopping Cart</h1>
  <div class='cart-layout'>
    <div>
    <?php while($item = mysqli_fetch_assoc($cart)): $subtotal += $item['price'] * $item['quantity']; ?>
      <div class='cart-item'>
        <?php if($item['image_path']): ?><img src='uploads/<?php echo $item["image_path"]; ?>'><?php endif; ?>
        <div style='flex:1'>
          <div style='font-size:12px;color:#666;'><?php echo $item['brand']; ?></div>
          <div style='font-weight:600;'><?php echo $item['item_name']; ?></div>
          <div style='font-size:13px;color:#666;'>Size: <?php echo $item['size']; ?> &bull; Seller: @<?php echo $item['seller']; ?></div>
          <div style='font-weight:700;margin-top:6px;'>R<?php echo $item['price']; ?></div>
        </div>
        <a href='cart.php?remove=<?php echo $item["cart_id"]; ?>' style='color:#999;font-size:20px;text-decoration:none;'>&#128465;</a>
      </div>
    <?php endwhile; ?>
    </div>
    <div class='order-summary'>
      <h3>Order Summary</h3>
      <div class='order-row'><span>Subtotal</span><span>R<?php echo $subtotal; ?></span></div>
      <div class='order-row'><span>Shipping</span><span>R<?php echo $shipping; ?></span></div>
      <div class='order-row order-total'><span>Total</span><span>R<?php echo $subtotal + $shipping; ?></span></div>
      <a href='checkout.php' class='btn-primary' style='display:block;text-align:center;text-decoration:none;margin-top:16px;padding:14px;'>Proceed to Checkout</a>
      <a href='index.php' class='btn-secondary' style='display:block;text-align:center;text-decoration:none;margin-top:10px;padding:14px;'>Continue Shopping</a>
    </div>
  </div>
</div>
</body>
</html>
