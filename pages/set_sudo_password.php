<?php
include '../includes/db_connect.php';

$user_id = 2;
$sudo_password = "admin123"; // নতুন পাসওয়ার্ড
$hashed_password = password_hash($sudo_password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE users SET sudo_password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed_password, $user_id);
$stmt->execute();
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Sudo Password</title>
    <link rel="stylesheet" href="/assets/css/set_sudo.css">
</head>
<body>
    <div class="container">
        <h1>Set Sudo Password</h1>
        <div class="message">
            <p>Sudo password set successfully for user ID <?php echo htmlspecialchars($user_id); ?>.</p>
        </div>
    </div>
</body>
</html>