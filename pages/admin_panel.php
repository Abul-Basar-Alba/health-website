<?php
session_start();
include '../includes/db_connect.php';
require '../vendor/autoload.php';
$config = include('../config.php');

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}

if (!isset($_SESSION['sudo_verified']) || $_SESSION['sudo_verified'] !== true) {
    header("Location: /pages/sudo_check.php");
    exit;
}

$admin_id = $_SESSION['id'];
$errors = [];


// Pusher initialization
$pusher = new Pusher\Pusher(
    $config['pusher']['key'],
    $config['pusher']['secret'],
    $config['pusher']['app_id'],
    $config['pusher']['options']
);

// Handle reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_id']) && isset($_POST['reply'])) {
    $reply_id = $_POST['reply_id'];
    $reply = trim($_POST['reply']);

    if (empty($reply)) {
        $errors[] = "Reply cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE private_messages SET reply = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND admin_id = ?");
        $stmt->bind_param("sii", $reply, $reply_id, $admin_id);
        $stmt->execute();
        $stmt->close();

        $pusher->trigger('private-channel', 'new-reply', [
            'reply' => $reply,
            'message_id' => $reply_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}

// Fetch private messages with usernames
$stmt = $conn->prepare("SELECT pm.*, u.username FROM private_messages pm JOIN users u ON pm.user_id = u.id WHERE pm.admin_id = ? ORDER BY pm.created_at DESC");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$private_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

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
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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
        </div>
    </div>

    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('<?php echo $config['pusher']['key']; ?>', {
            cluster: '<?php echo $config['pusher']['cluster']; ?>'
        });

        var channel = pusher.subscribe('private-channel');
        channel.bind('new-private-message', function(data) {
            var messagesDiv = document.getElementById('private-messages');
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_username.php?user_id=' + data.user_id, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    var username = JSON.parse(xhr.responseText).username;
                    var newMessage = document.createElement('div');
                    newMessage.className = 'message';
                    newMessage.innerHTML = `<p>From ${username} at ${data.created_at}</p><p>Message: ${data.message}</p>`;
                    messagesDiv.insertBefore(newMessage, messagesDiv.firstChild);
                }
            };
            xhr.send();
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>