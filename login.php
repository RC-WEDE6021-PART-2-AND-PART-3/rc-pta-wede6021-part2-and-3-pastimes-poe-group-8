<?php
session_start();
include 'DBConnect.php';
$error = '';
$sticky_username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $hashed = md5($password);
  $sticky_username = $username;

  $result = mysqli_query($conn, "SELECT * FROM tblUser WHERE username='$username' AND password='$hashed'");

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if ($user['seller_verified'] == 0) {
      $error = 'Your account is pending admin approval.';
    } else {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['full_name'] = $user['full_name'];
      $_SESSION['user_type'] = $user['user_type'];
      $_SESSION['seller_verified'] = $user['seller_verified'];
      if ($user['user_type'] == 'admin') {
        header('Location: admin.php'); exit();
      } else {
        header('Location: index.php'); exit();
      }
    }
  } else {
    $error = 'Invalid username or password.';
  }
}
?>
<!DOCTYPE html><html><head><title>Login - Pastimes</title><link rel='stylesheet' href='css/style.css'></head><body>
<?php include 'nav.php'; ?>
<div class='auth-container'>
  <?php if(isset($_SESSION['full_name'])): ?>
    <div class='success'>User <?php echo $_SESSION['full_name']; ?> is logged in</div>
  <?php endif; ?>
  <h1 class='auth-title'>Welcome Back</h1>
  <p class='auth-sub'>Sign in to your Pastimes account</p>
  <?php if($error): ?><div class='error'><?php echo $error; ?></div><?php endif; ?>
  <form method='POST'>
    <label style='font-size:14px;font-weight:600;display:block;margin-bottom:6px;'>Username</label>
    <input type='text' name='username' placeholder='Enter your username' value='<?php echo $sticky_username; ?>' required>
    <label style='font-size:14px;font-weight:600;display:block;margin-bottom:6px;'>Password</label>
    <input type='password' name='password' placeholder='Enter your password' required>
    <button type='submit' class='btn-primary' style='width:100%;padding:14px;margin-top:8px;'>Sign In</button>
  </form>
  <div class='auth-link'>Don't have an account? <a href='register.php'>Create one</a></div>
</div>
</body></html>
