<?php
session_start();
include 'includes/index_header.php';

// Check if user just registered
$justRegistered = isset($_GET['registered']) && $_GET['registered'] == 'true';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <!-- Welcome Message -->
    <div class="welcome-container">
        <?php if($justRegistered): ?>
            <span class="emoji">🎉</span>
            <h2>Welcome aboard, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
            <p class="welcome-message">
                Congratulations on starting your journey towards a healthier lifestyle! <br>
                Remember, progress is not always about speed, but consistency. <br>
                <span class="highlight">Small steps lead to big results. Keep going!</span>
            </p>
        <?php else: ?>
            <h2>Hello, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
            <p class="welcome-message">
                You're one step closer to achieving your health and fitness goals. <br>
                Consistency is key, and you're on the right path! <br>
                <span class="highlight">Let's stay motivated and keep making progress!</span>
            </p>
        <?php endif; ?>
    </div>

    <!-- Main Health Form -->
    <h1>Welcome to Health Nutrition Guide</h1>
    <form id="healthForm" action="calculate.php" method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" required>

        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" step="0.1" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="1" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <button type="submit" aria-label="Calculate nutrient needs">Calculate</button>
    </form>

    <!-- Call to Action -->
    <div class="cta-section">
        <h2>Need Personalized Advice?</h2>
        <p>Our nutrition experts are here to help you achieve your health goals.</p>
        <a href="pages/contact.php" class="home-contact-btn" aria-label="Contact our experts">
            <i class="fas fa-envelope"></i> Contact Our Experts
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/calculate.js" defer></script>