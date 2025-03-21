<?php include '../includes/header.php'; ?>

<div class="container signup-container">
    <h1>Sign Up</h1>
    <form action="signup_process.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="signup-btn">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<?php include '../includes/footer.php'; ?>
