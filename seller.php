<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
if ($_SESSION['seller_verified'] != 1) { echo 'Your seller account is not verified yet.'; exit(); }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $item_name = trim($_POST['item_name']);
  $brand = trim($_POST['brand']);
  $size = $_POST['size'];
  $condition = $_POST['condition_desc'];
  $price = $_POST['price'];
  $desc = trim($_POST['description']);
  $seller_id = $_SESSION['user_id'];
  $image_path = '';

  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename);
    $image_path = $filename;
  }

  mysqli_query($conn, "INSERT INTO listings (seller_id, item_name, brand, size, condition_desc, price, image_path) VALUES ($seller_id, '$item_name', '$brand', '$size', '$condition', '$price', '$image_path')");
  $msg = 'Listing published successfully!';
}

$my_listings = mysqli_query($conn, "SELECT * FROM listings WHERE seller_id = {$_SESSION['user_id']} ORDER BY created_at DESC");
?>
<!DOCTYPE html><html><head><title>Seller Dashboard - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:28px;font-weight:700;'>Seller Dashboard</h1>
  <p style='color:#666;margin-bottom:32px;'>List your pre-loved items for sale</p>
  <?php if ($msg): ?><div class='success'><?php echo $msg; ?></div><?php endif; ?>
  <div class='card'>
    <h2 style='margin-bottom:20px;'>Create New Listing</h2>
    <form method='POST' enctype='multipart/form-data'>
      <div class='upload-area' onclick="document.getElementById('imgInput').click()">
        <div style='font-size:32px;margin-bottom:8px;'>&#8679;</div>
        <div style='font-weight:600;'>Upload Item Images</div>
        <div style='color:#666;font-size:13px;'>Click to browse or drag and drop</div>
        <input type='file' id='imgInput' name='image' accept='image/*' style='display:none;'>
      </div>
      <div class='form-grid'>
        <input type='text' name='item_name' placeholder='Item Name e.g. Vintage Denim Jacket' required>
        <input type='text' name='brand' placeholder="Brand e.g. Levi's" required>
        <select name='size' required><option value=''>Select size</option><option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option></select>
        <select name='condition_desc' required><option value=''>Select condition</option><option>Like New</option><option>Good</option><option>Fair</option></select>
      </div>
      <input type='number' name='price' placeholder='Price (R)' step='0.01' required>
      <textarea name='description' rows='4' placeholder='Describe the item...'></textarea>
      <div style='display:flex;gap:12px;'>
        <button type='submit' class='btn-primary'>Publish Listing</button>
      </div>
    </form>
  </div>
  <h2 style='margin:32px 0 16px;'>Your Active Listings</h2>
  <?php if (mysqli_num_rows($my_listings) == 0): ?>
    <div class='card' style='text-align:center;color:#666;'>No active listings yet. Create your first listing above.</div>
  <?php else: ?>
  <table><tr><th>Item</th><th>Brand</th><th>Size</th><th>Price</th><th>Status</th></tr>
  <?php while($l = mysqli_fetch_assoc($my_listings)): ?>
  <tr><td><?php echo $l['item_name']; ?></td><td><?php echo $l['brand']; ?></td><td><?php echo $l['size']; ?></td><td>R<?php echo $l['price']; ?></td><td><?php echo $l['is_sold'] ? '<span class="badge-pending">Sold</span>' : '<span class="badge-verified">Active</span>'; ?></td></tr>
  <?php endwhile; ?>
  </table>
  <?php endif; ?>
</div></body></html>
