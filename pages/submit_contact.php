<?php
include '../includes/db_connect.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $weight = floatval($_POST['weight']);
    $age = intval($_POST['age']);
    $height = floatval($_POST['height']);
    $district = trim($_POST['district']);
    $country = trim($_POST['country']);
    $message = trim($_POST['message']);

    // Input validation
    if (empty($name) || empty($email) || $weight <= 0 || $age <= 0 || $height <= 0 || empty($district) || empty($country) || empty($message)) {
        $error = "Please fill in all fields with valid values.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, weight, age, height, district, country, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $error = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("ssdissss", $name, $email, $weight, $age, $height, $district, $country, $message);
            if ($stmt->execute()) {
                $success = "Thank you for contacting us! We will get back to you soon.";
            } else {
                $error = "Failed to submit your message: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<div class="submit-contact-container">
    <h1>Contact Submission</h1>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <a href="../home.php" class="submit-contact-btn"><i class="fas fa-home"></i> Back to Home</a>
    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <a href="contact.php" class="submit-contact-btn"><i class="fas fa-arrow-left"></i> Try Again</a>
    <?php else: ?>
        <p>Something went wrong. Please try again.</p>
        <a href="contact.php" class="submit-contact-btn"><i class="fas fa-arrow-left"></i> Back to Contact Form</a>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>