<?php
session_start();
include 'DBConnect.php';
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') { header('Location: login.php'); exit(); }

$msg = '';

// Verify user
if (isset($_GET['verify'])) {
  $id = (int)$_GET['verify'];
  mysqli_query($conn, "UPDATE tblUser SET seller_verified=1 WHERE user_id=$id");
  $msg = 'User verified.';
}

// Delete user
if (isset($_GET['delete_user'])) {
  $id = (int)$_GET['delete_user'];
  mysqli_query($conn, "DELETE FROM tblUser WHERE user_id=$id");
  $msg = 'User deleted.';
}

// Delete listing
if (isset($_GET['delete_listing'])) {
  $id = (int)$_GET['delete_listing'];
  mysqli_query($conn, "DELETE FROM listings WHERE listing_id=$id");
  $msg = 'Listing removed.';
}

// Add new user via form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
  $fn = $_POST['full_name'];
  $em = $_POST['email'];
  $un = $_POST['username'];
  $pw = md5($_POST['password']);
  $ut = $_POST['user_type'];
  mysqli_query($conn, "INSERT INTO tblUser (full_name, email, username, password, user_type, seller_verified) VALUES ('$fn','$em','$un','$pw','$ut',1)");
  $msg = 'User added.';
}

$pending = mysqli_query($conn, "SELECT * FROM tblUser WHERE seller_verified=0");
$users = mysqli_query($conn, "SELECT * FROM tblUser ORDER BY created_at DESC");
$listings = mysqli_query($conn, "SELECT l.*, u.username FROM listings l JOIN tblUser u ON l.seller_id = u.user_id ORDER BY l.created_at DESC");
?>
<!DOCTYPE html><html><head><title>Admin - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='container'>
  <h1 style='font-size:28px;font-weight:700;margin-bottom:24px;'>Admin Dashboard</h1>
  <?php if($msg): ?><div class='success'><?php echo $msg; ?></div><?php endif; ?>

  <h2 style='margin-bottom:16px;'>Pending Seller Verifications</h2>
  <table>
    <tr><th>Name</th><th>Email</th><th>Username</th><th>Joined</th><th>Actions</th></tr>
    <?php while($u = mysqli_fetch_assoc($pending)): ?>
    <tr><td><?php echo $u['full_name']; ?></td><td><?php echo $u['email']; ?></td><td>@<?php echo $u['username']; ?></td><td><?php echo date('Y-m-d', strtotime($u['created_at'])); ?></td>
    <td><a href='admin.php?verify=<?php echo $u["user_id"]; ?>' style='color:green;margin-right:10px;'>&#10003; Verify</a><a href='admin.php?delete_user=<?php echo $u["user_id"]; ?>' style='color:red;'>&#10005; Delete</a></td></tr>
    <?php endwhile; ?>
  </table>

  <h2 style='margin:32px 0 16px;'>All Users</h2>
  <table>
    <tr><th>Name</th><th>Email</th><th>Username</th><th>Type</th><th>Status</th><th>Actions</th></tr>
    <?php mysqli_data_seek($users, 0); while($u = mysqli_fetch_assoc($users)): ?>
    <tr><td><?php echo $u['full_name']; ?></td><td><?php echo $u['email']; ?></td><td>@<?php echo $u['username']; ?></td><td><?php echo $u['user_type']; ?></td><td><?php echo $u['seller_verified'] ? '<span class="badge-verified">Verified</span>' : '<span class="badge-pending">Pending</span>'; ?></td>
    <td><a href='admin.php?verify=<?php echo $u["user_id"]; ?>' style='color:green;margin-right:8px;'>Verify</a><a href='admin.php?delete_user=<?php echo $u["user_id"]; ?>' style='color:red;'>Delete</a></td></tr>
    <?php endwhile; ?>
  </table>

  <h2 style='margin:32px 0 16px;'>Active Listings</h2>
  <table>
    <tr><th>Item</th><th>Seller</th><th>Price</th><th>Listed</th><th>Actions</th></tr>
    <?php while($l = mysqli_fetch_assoc($listings)): ?>
    <tr><td><?php echo $l['item_name']; ?></td><td>@<?php echo $l['username']; ?></td><td>R<?php echo $l['price']; ?></td><td><?php echo date('Y-m-d', strtotime($l['created_at'])); ?></td>
    <td><a href='admin.php?delete_listing=<?php echo $l["listing_id"]; ?>' style='color:red;'>&#128465; Remove</a></td></tr>
    <?php endwhile; ?>
  </table>

  <h2 style='margin:32px 0 16px;'>Add New User</h2>
  <div class='card'>
    <form method='POST'>
      <div class='form-grid'>
        <input type='text' name='full_name' placeholder='Full Name' required>
        <input type='email' name='email' placeholder='Email' required>
        <input type='text' name='username' placeholder='Username' required>
        <input type='password' name='password' placeholder='Password' required>
        <select name='user_type'><option value='buyer'>Buyer</option><option value='seller'>Seller</option><option value='admin'>Admin</option></select>
      </div>
      <button type='submit' name='add_user' class='btn-primary'>Add User</button>
    </form>
  </div>
</div></body></html>
