<?php
session_start();
include '../includes/db_connect.php';
require '../vendor/autoload.php';
$config = include('../config.php');

if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
    exit;
}

$user_id = $_SESSION['id'];
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$errors = []; // Error messages storage

// Pusher initialization
$pusher = new Pusher\Pusher(
    $config['pusher']['key'],
    $config['pusher']['secret'],
    $config['pusher']['app_id'],
    $config['pusher']['options']
);

// Handle public message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['public_message'])) {
    $message = trim($_POST['public_message']);

    if (empty($message)) {
        $errors[] = "Public message cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO public_messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $message);
        $stmt->execute();
        $stmt->close();

        $pusher->trigger('public-channel', 'new-message', [
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

// Handle private message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['private_message'])) {
    $message = trim($_POST['private_message']);
    $admin_id = 1;

    if (empty($message)) {
        $errors[] = "Private message cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO private_messages (user_id, admin_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $admin_id, $message);
        $stmt->execute();
        $stmt->close();

        $pusher->trigger('private-channel', 'new-private-message', [
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

// Fetch public messages with usernames
$stmt = $conn->prepare("SELECT pm.*, u.username FROM public_messages pm JOIN users u ON pm.user_id = u.id ORDER BY pm.created_at DESC");
$stmt->execute();
$public_messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

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
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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
        </div>
    </div>

    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('<?php echo $config['pusher']['key']; ?>', {
            cluster: '<?php echo $config['pusher']['cluster']; ?>'
        });

        var channel = pusher.subscribe('public-channel');
        channel.bind('new-message', function(data) {
            var messagesDiv = document.getElementById('public-messages');
            var stmt = new XMLHttpRequest();
            stmt.open('GET', 'get_username.php?user_id=' + data.user_id, true);
            stmt.onload = function() {
                if (stmt.status == 200) {
                    var username = JSON.parse(stmt.responseText).username;
                    var newMessage = document.createElement('div');
                    newMessage.className = 'message';
                    newMessage.innerHTML = `<p>${data.message} (Posted by ${username} at ${data.created_at})</p>`;
                    messagesDiv.insertBefore(newMessage, messagesDiv.firstChild);
                }
            };
            stmt.send();
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>