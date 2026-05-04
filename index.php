<?php
include 'DbConnect.php';

$result = mysqli_query($conn, "SELECT * FROM listings WHERE is_sold=0");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Pastimes Shop</title>
<style>
body {
    font-family: Arial;
    background: #F5F5F0;
}
.navbar {
    background: white;
    padding: 10px;
}
.container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}
.card {
    background: white;
    padding: 15px;
    width: 200px;
}
img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}
button {
    background: #E8491E;
    color: white;
    border: none;
    padding: 8px;
    width: 100%;
    margin-top: 5px;
}
</style>
</head>

<body>

<div class="navbar">
    <a href="index.php">Shop</a> |
    <a href="cart.php">Cart</a> |
    <a href="seller.php">Sell</a> |
    <a href="logout.php">Logout</a>
</div>

<h2 style="padding:20px;">Shop</h2>

<div class="container">
<?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="card">
        <img src="<?= htmlspecialchars($row['image_path']) ?>">
        <h3><?= htmlspecialchars($row['item_name']) ?></h3>
        <p>R<?= htmlspecialchars($row['price']) ?></p>

        <a href="add_to_cart.php?id=<?= $row['listing_id'] ?>">
            <button>Add to Cart</button>
        </a>

        <a href="add_to_wishlist.php?id=<?= $row['listing_id'] ?>">
            <button>Wishlist</button>
        </a>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>