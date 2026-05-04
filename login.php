<!DOCTYPE html>
<html>
<head>
    <title>Login - Pastimes</title>
    <style>
        body {
            font-family: Arial;
            background: #F5F5F0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: white;
            padding: 30px;
            width: 300px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        button {
            background: #E8491E;
            color: white;
            border: none;
        }
        .admin-btn {
            background: #333;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Welcome Back</h2>

   <?php
include 'DbConnect.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed = md5($password);

    $query = "SELECT * FROM tbluser 
              WHERE username='$username' 
              AND email='$email' 
              AND password='$hashed'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type'] = $user['user_type'];

        //REDIRECT TO SHOP
        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid login details.";
    }
}
?>

    <?php if (!empty($error)) echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>

        <button type="submit">Sign In</button>
    </form>

    <!--ADMIN PAGE REDIRECT BUTTON--> 
    <form action="admin.php" method="GET">
        <button type="submit" class="admin-btn">Admin Login</button>
    </form>

    <a href="register.php">Create account</a>
</div>

</body>
</html>