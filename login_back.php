<?php
session_start();
include "connection.php";

$username = $_REQUEST["username"];
$password = $_REQUEST["password"];
$user_type = $_REQUEST["user_type"]; // Get user type from login form

if ($user_type == "admin") {
    // Admin authentication
    $query = "SELECT id, username, password FROM admin WHERE username='$username'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    
    if ($row = mysqli_fetch_assoc($result)) {
        if ($row["password"] == $password) { // Change to password_verify() if hashed
            $_SESSION['username'] = $username;
            echo "<script>alert('Admin Login Successful');</script>";
            echo '<script>window.location.href = "admin_dashboard.php";</script>';
            exit();
        }
    }
} elseif ($user_type == "user") {
    // User authentication
    $query = "SELECT * FROM user WHERE email='$username'"; // Assuming users log in with email


    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    
    if ($row = mysqli_fetch_assoc($result)) {
        if ($row["pass"] == $password) { // Change to password_verify() if hashed
            $_SESSION['username'] = $username;
            echo "<script>alert('User Login Successful');</script>";
            echo '<script>window.location.href = "user_dashboard.php";</script>';
            exit();
        }
    }
}

// If login fails
echo "<script>alert('Wrong username or password');</script>";
echo '<script>window.location.href = "index.php";</script>';
exit();

mysqli_close($link);
?>
