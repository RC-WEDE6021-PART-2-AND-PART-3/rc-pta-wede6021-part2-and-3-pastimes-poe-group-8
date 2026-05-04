<?php
include 'DbConnect.php';

//Deletes the tbluser table if it already exist
$drop = "DROP TABLE IF EXISTS tbluser";
mysqli_query($conn, $drop);

mysqli_query($conn, "CREATE TABLE tbluser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    user_type ENUM('buyer','seller','admin') DEFAULT 'buyer',
    seller_verified TINYINT(1) DEFAULT 0
)");

$file = fopen("userData.txt", "r");

while (!feof($file)) {
    $line = fgets($file);
    $line = trim($line);
    
    if ($line != "") {
        $data = explode(",", $line);
        $full_name = trim($data[0]);
        $email = trim($data[1]);
        $username = trim($data[2]);
        $password = trim($data[3]);

        $insert = "INSERT INTO tbluser (full_name, email, username, password) 
                   VALUES ('$full_name', '$email', '$username', '$password')";
        mysqli_query($conn, $insert);
    }
}

fclose($file);
echo "Tables created!";
?>