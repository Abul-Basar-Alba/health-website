<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
    exit;
}

$user_id = $_SESSION['id'];
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$errors = [];

// অ্যাডমিনের ID ফেচ করা
$admin_id = null;
if (!$is_admin) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    if (!$stmt) {
        $errors[] = "Database error: Failed to prepare query for admin ID.";
    } else {
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $admin_id = $admin ? $admin['id'] : null;
        $stmt->close();
        if (!$admin_id) {
            $errors[] = "No admin found in the database.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['public_message'])) {
    $message = trim($_POST['public_message']);

    if (empty($message)) {
        $errors[] = "Public message cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO public_messages (user_id, message) VALUES (?, ?)");
        if (!$stmt) {
            $errors[] = "Database error: Failed to prepare query for public message.";
        } else {
            $stmt->bind_param("is", $user_id, $message);
            if (!$stmt->execute()) {
                $errors[] = "Database error: Failed to insert public message.";
            }
            $stmt->close();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['private_message'])) {
    $message = trim($_POST['private_message']);

    if (empty($message)) {
        $errors[] = "Private message cannot be empty.";
    } elseif ($admin_id === null) {
        $errors[] = "Cannot send message: Admin ID not found.";
    } else {
        $stmt = $conn->prepare("INSERT INTO private_messages (user_id, admin_id, message) VALUES (?, ?, ?)");
        if (!$stmt) {
            $errors[] = "Database error: Failed to prepare query for private message.";
        } else {
            $stmt->bind_param("iis", $user_id, $admin_id, $message);
            if (!$stmt->execute()) {
                $errors[] = "Database error: Failed to insert private message.";
            }
            $stmt->close();
        }
    }
}

$stmt = $conn->prepare("SELECT pm.*, u.username FROM public_messages pm JOIN users u ON pm.user_id = u.id ORDER BY pm.created_at DESC");
if (!$stmt) {
    $errors[] = "Database error: Failed to prepare query for public messages.";
} else {
    $stmt->execute();
    $public_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// ইউজারের পাঠানো প্রাইভেট মেসেজ এবং অ্যাডমিনের রিপ্লাই ফেচ করা
$stmt = $conn->prepare("SELECT pm.*, u.username FROM private_messages pm JOIN users u ON pm.admin_id = u.id WHERE pm.user_id = ? ORDER BY pm.created_at DESC");
if (!$stmt) {
    $errors[] = "Database error: Failed to prepare query for private messages.";
} else {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $private_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging</title>
    <link rel="stylesheet" href="/assets/css/messaging.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1>Messaging Community</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="section">
            <h2>Public Community Questions</h2>
            <form method="POST" action="">
                <textarea name="public_message" placeholder="Ask a question..." required></textarea>
                <button type="submit">Post Question</button>
            </form>
            <div id="public-messages">
                <?php foreach ($public_messages as $msg): ?>
                    <div class="message">
                        <p><?php echo htmlspecialchars($msg['message']); ?> (Posted by <?php echo htmlspecialchars($msg['username']); ?> at <?php echo $msg['created_at']; ?>)</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="section">
            <h2>Private Messaging (Admin Only)</h2>
            <form method="POST" action="">
                <textarea name="private_message" placeholder="Send a private message to admin..." required></textarea>
                <button type="submit">Send Message</button>
            </form>
            <div id="private-messages">
                <h3>Your Private Messages</h3>
                <?php if (empty($private_messages)): ?>
                    <p>No private messages found.</p>
                <?php else: ?>
                    <?php foreach ($private_messages as $msg): ?>
                        <div class="message">
                            <p>Sent to Admin at <?php echo $msg['created_at']; ?></p>
                            <p>Message: <?php echo htmlspecialchars($msg['message']); ?></p>
                            <?php if ($msg['reply']): ?>
                                <p>Reply from Admin: <?php echo htmlspecialchars($msg['reply']); ?> (Replied at <?php echo $msg['updated_at']; ?>)</p>
                            <?php else: ?>
                                <p>No reply yet.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>