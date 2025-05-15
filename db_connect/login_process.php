<?php
session_start();
include '../includes/db_connect.php'; // Make sure path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_info WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: ../home.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }

    header("Location: ../db_connect/login.php?error=" . urlencode($error));
    exit();
}
?>
