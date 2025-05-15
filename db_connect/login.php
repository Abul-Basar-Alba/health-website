<?php 
include '../includes/db_connect.php'; // Connect to the database
include '../includes/index_header.php';
 
?>

<body class="login-page">
    <div class="login-container">
        <h1>Login</h1>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
    <!-- Ensure only the correct CSS file is linked -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</body>

<?php include '../includes/footer.php'; ?>
