<?php
//session_start();
include 'db_connect.php';
echo "Session ID: " . ($_SESSION['id'] ?? 'Not set') . "<br>";
echo "Session Role: " . ($_SESSION['role'] ?? 'Not set') . "<br>";
?>
<header>
    <nav>
        <div class="logo"></div>
        <div class="main-nav">
            <a href="/home.php"><i class="fas fa-home"></i> Home</a>
            <a href="/pages/docs.php"><i class="fas fa-book"></i> Docs</a>
            <a href="/pages/nutrition.php"><i class="fas fa-apple-alt"></i> Nutrition</a>
            <a href="/pages/recommendations.php"><i class="fas fa-clipboard-list"></i> Recommendations</a>
            <a href="/pages/about.php"><i class="fas fa-info-circle"></i> About</a>
            <a href="/pages/contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <?php if (isset($_SESSION['id'])): ?>
                <a href="/pages/messaging.php"><i class="fas fa-comments"></i> Messaging</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/pages/admin_panel.php"><i class="fas fa-user-shield"></i> Admin</a>
                <?php endif; ?>
                <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php else: ?>
                <a href="/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<link rel="stylesheet" href="/assets/css/common.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
