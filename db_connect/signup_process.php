<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age      = (int) $_POST['age'];
    $weight   = (float) $_POST['weight'];

    $sql = "INSERT INTO user_info (username, email, password, age, weight) 
            VALUES ('$username', '$email', '$password', $age, $weight)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../db_connect/login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
