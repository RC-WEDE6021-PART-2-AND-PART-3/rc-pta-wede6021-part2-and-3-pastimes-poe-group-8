<?php
include 'DbConnect.php';
session_start();

$user_id = (int) $_SESSION['user_id'];

$result = mysqli_query($conn, "
SELECT listings.* FROM cart
JOIN listings ON cart.listing_id = listings.listing_id
WHERE cart.user_id = $user_id
");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
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

<h2 style="padding:20px;">Your Cart</h2>

<div class="container">

<?php if (mysqli_num_rows($result) == 0): ?>
    <p style="padding:20px;">Your cart is empty.</p>
<?php else: ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($row['image_path']) ?>">
            <h3><?= htmlspecialchars($row['item_name']) ?></h3>
            <p>R<?= htmlspecialchars($row['price']) ?></p>

            <!-- Optional remove button (future use) -->
            <!--
            <a href="remove_from_cart.php?id=<?= $row['listing_id'] ?>">
                <button>Remove</button>
            </a>
            -->
        </div>
    <?php endwhile; ?>
<?php endif; ?>

</div>

</body>
</html>