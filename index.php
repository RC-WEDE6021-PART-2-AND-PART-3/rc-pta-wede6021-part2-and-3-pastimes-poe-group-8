<?php
session_start();
include 'DBConnect.php';
 // put nav.php include after <body> opens

$search = isset($_GET['search']) ? $_GET['search'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';

$query = "SELECT l.*, u.username as seller_name FROM listings l JOIN tblUser u ON l.seller_id = u.user_id WHERE l.is_sold = 0";
if ($search) $query .= " AND (l.item_name LIKE '%$search%' OR l.brand LIKE '%$search%')";
if ($size) $query .= " AND l.size = '$size'";
if ($brand) $query .= " AND l.brand LIKE '%$brand%'";
if ($price == 'low') $query .= " AND l.price < 50";
if ($price == 'mid') $query .= " AND l.price BETWEEN 50 AND 150";
if ($price == 'high') $query .= " AND l.price > 150";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html><html><head>
<title>Pastimes</title>
<link rel='stylesheet' href='css/style.css'>
</head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:36px;font-weight:700;margin-bottom:24px;'>Discover Timeless Pieces</h1>
  <form method='GET'>
    <div class='search-bar'>
      <input type='text' name='search' placeholder='Search clothing, brands, styles...' value='<?php echo $search; ?>'>
      <button type='submit' class='btn-primary'>Search</button>
    </div>
    <div class='filters'>
      <select name='size'><option value=''>All Sizes</option><option value='XS'>XS</option><option value='S'>S</option><option value='M'>M</option><option value='L'>L</option><option value='XL'>XL</option></select>
      <select name='brand'><option value=''>All Brands</option><option>Levi's</option><option>Nike</option><option>Adidas</option><option>Zara</option><option>H&M</option><option>Burberry</option><option>Ralph Lauren</option></select>
      <select name='price'><option value=''>All Prices</option><option value='low'>Under R50</option><option value='mid'>R50 - R150</option><option value='high'>Over R150</option></select>
      <button type='submit' class='btn-secondary'>Apply Filters</button>
    </div>
  </form>
  <div class='listings-grid'>
  <?php while($item = mysqli_fetch_assoc($result)): ?>
    <div class='listing-card'>
      <?php if($item['image_path']): ?>
        <img src='uploads/<?php echo $item["image_path"]; ?>' alt='<?php echo $item["item_name"]; ?>'>
      <?php else: ?>
        <div style='height:220px;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#999;'>No Image</div>
      <?php endif; ?>
      <div class='info'>
        <div class='brand'><?php echo $item['brand']; ?></div>
        <div class='name'><?php echo $item['item_name']; ?></div>
        <div>
          <span class='price'>R<?php echo $item['price']; ?></span>
          <span class='size'><?php echo $item['size']; ?></span>
        </div>
        <div style='display:flex;gap:8px;margin-top:10px;'>
          <a href='add_to_cart.php?id=<?php echo $item["listing_id"]; ?>' class='btn-primary' style='font-size:12px;padding:8px 12px;text-decoration:none;'>Add to Cart</a>
          <a href='add_to_wishlist.php?id=<?php echo $item["listing_id"]; ?>' class='btn-secondary' style='font-size:12px;padding:8px 12px;text-decoration:none;'>&#9825;</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div>
</div>
</body></html>
