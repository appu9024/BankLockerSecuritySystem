<?php
session_start();
include 'connection.php'; // Include the database connection

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../index.php';</script>";
    exit;
}

$user_id = $_GET['id']; // Get the user ID from the request

if ($user_id) {
    // Update the access level to 0 (stop access)
    $query = "UPDATE user SET access = 0 WHERE id = '$user_id'";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "<script>alert('Access has been stopped.'); window.location.href='access.php';</script>";
    } else {
        echo "<script>alert('Failed to stop access.'); window.location.href='access.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='access.php';</script>";
}
?>
