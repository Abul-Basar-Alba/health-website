<?php include 'includes/header.php'; ?>

<div class="signup-container">
    <h1>Sign Up</h1>
    <form action="signup_process.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>