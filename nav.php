<?php
 if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav>
  <div class="nav-logo">
    <span>&#9749;</span> Pastimes
  </div>
  <div class="nav-links">
    <a href="index.php">Shop</a>
    <a href="seller.php">Sell</a>
    <a href="wishlist.php">&#9825;</a>
    <a href="cart.php">&#9788;</a>
    <a href="messages.php">&#9993;</a>
    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin'): ?>
      <a href="admin.php" style="color:#E8491E;font-weight:700;">Admin</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['user_id'])): ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </div>
</nav>
