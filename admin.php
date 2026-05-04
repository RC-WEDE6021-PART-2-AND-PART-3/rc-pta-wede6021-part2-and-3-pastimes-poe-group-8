<?php
include 'DbConnect.php';
session_start();

//make sure only admin can access

// Handle actions safely
if (isset($_GET['verify'])) {
    $id = (int) $_GET['verify'];
    mysqli_query($conn, "UPDATE tbluser SET seller_verified=1 WHERE user_id=$id");
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tbluser WHERE user_id=$id");
}

// Fetch sellers
$result = mysqli_query($conn, "SELECT * FROM tbluser WHERE user_type='seller'");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
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
    padding: 20px;
}
.card {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
}
button {
    background: #E8491E;
    color: white;
    border: none;
    padding: 8px;
    margin-top: 5px;
    cursor: pointer;
}
a {
    text-decoration: none;
}
.status {
    font-weight: bold;
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

<h2 style="padding:20px;">Admin Panel</h2>

<div class="container">

<?php if (mysqli_num_rows($result) == 0): ?>
    <p>No sellers found.</p>
<?php else: ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
            <p><strong><?= htmlspecialchars($row['username']) ?></strong></p>

            <p class="status">
                Status:
                <?= $row['seller_verified'] ? 'Verified' : 'Pending' ?>
            </p>

            <?php if (!$row['seller_verified']): ?>
                <a href="?verify=<?= $row['user_id'] ?>">
                    <button>Verify</button>
                </a>
            <?php endif; ?>

            <a href="?delete=<?= $row['user_id'] ?>">
                <button>Delete</button>
            </a>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

</div>

</body>
</html>