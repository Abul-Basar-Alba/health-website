<?php
include '../includes/db_connect.php';

$user_id = 2; 
$sudo_password = "@12345678"; 
$hashed_password = password_hash($sudo_password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE users SET sudo_password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed_password, $user_id);
$stmt->execute();
$stmt->close();

echo "Sudo password set successfully for user ID $user_id.";
$conn->close();
?>