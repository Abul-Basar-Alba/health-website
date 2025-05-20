<?php
session_start();
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $age = intval($_POST['age']);
    $weight = floatval($_POST['weight']);

    // Input validation
    if (empty($username) || empty($email) || empty($password) || $age <= 0 || $weight <= 0) {
        $_SESSION['error'] = "Please fill in all fields with valid values.";
        header("Location: signup.php");
        exit;
    }

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: signup.php");
        exit;
    }

    // Password strength validation
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: signup.php");
        exit;
    }

    // Check if username or email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: signup.php");
        exit;
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: signup.php");
        exit;
    }
    $stmt->close();

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, age, weight) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: signup.php");
        exit;
    }
    $stmt->bind_param("sssii", $username, $email, $password, $age, $weight);
    if ($stmt->execute()) {
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        header("Location: home.php?registered=true");
        exit;
    } else {
        $_SESSION['error'] = "Registration failed: " . $stmt->error;
        header("Location: signup.php");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
<link rel="stylesheet" href="../assets/css/signup.css">
<body class="signup-page">
    <div class="signup-container">
        <h1>Sign Up</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="signup.php" method="POST">
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
                <input type="number" id="age" name="age" min="1" required class="form-control">
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" step="0.1" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

<?php include 'includes/footer.php'; ?>