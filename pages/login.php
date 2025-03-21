<?php include '../includes/header.php'; ?>

<div class="container login-container">
    <h1>Login</h1>
    <form action="login_process.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
</div>

<?php include '../includes/footer.php'; ?>
