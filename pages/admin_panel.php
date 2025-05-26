<?php
session_start();
include '../includes/db_connect.php';

// সেশন চেক
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}

$admin_id = $_SESSION['id'];
$errors = [];

// রিপ্লাই হ্যান্ডলিং
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_id']) && isset($_POST['reply'])) {
    $reply_id = $_POST['reply_id'];
    $reply = trim($_POST['reply']);

    if (empty($reply)) {
        $errors[] = "Reply cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE private_messages SET reply = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND admin_id = ?");
        if (!$stmt) {
            $errors[] = "Database error: Failed to prepare query for reply.";
        } else {
            $stmt->bind_param("sii", $reply, $reply_id, $admin_id);
            if (!$stmt->execute()) {
                $errors[] = "Database error: Failed to update reply.";
            }
            $stmt->close();
        }
    }
}

// প্রাইভেট মেসেজ ফেচ করা
$stmt = $conn->prepare("SELECT pm.*, u.username FROM private_messages pm JOIN users u ON pm.user_id = u.id WHERE pm.admin_id = ? ORDER BY pm.created_at DESC");
if (!$stmt) {
    $errors[] = "Database error: Failed to prepare query for private messages.";
} else {
    $stmt->bind_param("i", $admin_id);
    if (!$stmt->execute()) {
        $errors[] = "Database error: Failed to execute query for private messages.";
    } else {
        $private_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1>Admin Messaging Panel</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div id="private-messages">
            <?php if (empty($private_messages)): ?>
                <p>No private messages found.</p>
            <?php else: ?>
                <?php foreach ($private_messages as $msg): ?>
                    <div class="message">
                        <p>From <?php echo htmlspecialchars($msg['username']); ?> at <?php echo $msg['created_at']; ?></p>
                        <p>Message: <?php echo htmlspecialchars($msg['message']); ?></p>
                        <?php if (!$msg['reply']): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="reply_id" value="<?php echo $msg['id']; ?>">
                                <textarea name="reply" placeholder="Type your reply..." required></textarea>
                                <button type="submit">Send Reply</button>
                            </form>
                        <?php else: ?>
                            <p>Reply: <?php echo htmlspecialchars($msg['reply']); ?> (Replied at <?php echo $msg['updated_at']; ?>)</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>