<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$user_id = $_SESSION['user_id'];

if (isset($_GET['remove'])) {
  $wid = (int)$_GET['remove'];
  mysqli_query($conn, "DELETE FROM wishlist WHERE wishlist_id=$wid AND user_id=$user_id");
  header('Location: wishlist.php'); exit();
}

$items = mysqli_query($conn, "SELECT w.*, l.item_name, l.brand, l.price, l.size, l.image_path FROM wishlist w JOIN listings l ON w.listing_id = l.listing_id WHERE w.user_id=$user_id");
$count = mysqli_num_rows($items);
?>
<!DOCTYPE html><html><head><title>Wishlist - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:28px;font-weight:700;'>Your Wishlist</h1>
  <p style='color:#666;margin-bottom:24px;'><?php echo $count; ?> saved items</p>
  <div class='wishlist-grid'>
  <?php while($item = mysqli_fetch_assoc($items)): ?>
    <div class='wishlist-card'>
      <button class='wishlist-remove' onclick="location.href='wishlist.php?remove=<?php echo $item["wishlist_id"]; ?>'">&#10005;</button>
      <?php if($item['image_path']): ?><img src='uploads/<?php echo $item["image_path"]; ?>'><?php else: ?><div style='height:280px;background:#e0e0e0;border-radius:8px;'></div><?php endif; ?>
      <div style='padding:8px 0;'>
        <div style='font-size:12px;color:#666;'><?php echo $item['brand']; ?></div>
        <div style='font-weight:600;'><?php echo $item['item_name']; ?></div>
        <div style='display:flex;justify-content:space-between;'>
          <span style='font-weight:700;'>R<?php echo $item['price']; ?></span>
          <span style='font-size:12px;color:#666;'><?php echo $item['size']; ?></span>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div>
</div></body></html>
