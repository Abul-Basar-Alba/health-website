<?php include '../includes/index_header.php'; ?>

<body class="signup-page">
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
            
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" placeholder="Age" required class="form-control">
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" step="0.1" id="weight" name="weight" placeholder="Weight (kg)" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</body>

<?php include '../includes/footer.php'; ?>
