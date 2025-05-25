<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}

$user_id = $_SESSION['id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sudo_password = trim($_POST['sudo_password']);

    if (empty($sudo_password)) {
        $errors[] = "Sudo password is required.";
    } else {
        $stmt = $conn->prepare("SELECT sudo_password FROM users WHERE id = ? AND role = 'admin'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($sudo_password, $user['sudo_password'])) {
            $_SESSION['sudo_verified'] = true;
            header("Location: /pages/admin_panel.php");
            exit;
        } else {
            $errors[] = "Invalid sudo password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudo Admin Verification</title>
    <link rel="stylesheet" href="/assets/css/sudo.css">
</head>
<body>
    <div class="container">
        <h1>Sudo Admin Verification</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="sudo_password">Enter Sudo Password:</label>
            <input type="password" name="sudo_password" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>