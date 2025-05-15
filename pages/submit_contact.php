<?php

include '../includes/db_connect.php';
include '../includes/header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $district = $_POST['district'];
    $country = $_POST['country'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, weight, age, height, district, country, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdissss", $name, $email, $weight, $age, $height, $district, $country, $message);

    if ($stmt->execute()) {
      
        ?>
        <div class="submit-contact-container">
            <h1>Thank You!</h1>
            <p>Your message has been sent successfully. We will get back to you soon.</p>
            <a href="../home.php" class="home-contact-btn">Return to Home</a>
        </div>
        <?php
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

include '../includes/footer.php'; 
?>