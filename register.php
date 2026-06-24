<?php
include 'DbConnect.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {

        $hashed = md5($password);

        $query = "INSERT INTO tbluser (full_name, email, username, password, user_type)
                  VALUES ('$name', '$email', '$username', '$hashed', 'seller')";

        if (mysqli_query($conn, $query)) {

            // Redirect to login page after successful registration
            header("Location: login.php?registered=1");
            exit();

        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Pastimes</title>
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
            width: 320px;
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
    </style>
</head>

<body>

<div class="card">
    <h2>Join Pastimes</h2>

    <?php if (!empty($error)) echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; ?>

    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Create Account</button>
    </form>

    <a href="login.php">Sign in</a>
</div>

</body>
</html>