<?php
session_start();
include 'includes/header.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$justRegistered = isset($_GET['registered']) && $_GET['registered'] == 'true';
?>

<div class="container">
    <div class="welcome-container">
        <?php if ($justRegistered): ?>
            <span class="emoji">🎉</span>
            <h2>Welcome aboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="welcome-message">
                Congratulations on starting your journey towards a healthier lifestyle! <br>
                Remember, progress is not always about speed, but consistency. <br>
                <span class="highlight">Small steps lead to big results. Keep going!</span>
            </p>
        <?php else: ?>
            <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="welcome-message">
                You're one step closer to achieving your health and fitness goals. <br>
                Consistency is key, and you're on the right path! <br>
                <span class="highlight">Let's stay motivated and keep making progress!</span>
            </p>
        <?php endif; ?>
    </div>

    <h1>Welcome to Health Nutrition Guide</h1>
    <form id="healthForm" action="calculate.php" method="POST">
        <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" step="0.1" required class="form-control">
        </div>
        <div class="form-group">
            <label for="height">Height (cm):</label>
            <input type="number" id="height" name="height" step="0.1" required class="form-control">
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="1" required class="form-control">
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required class="form-control">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" aria-label="Calculate nutrient needs">Calculate</button>
    </form>

    <div class="cta-section">
        <h2>Need Personalized Advice?</h2>
        <p>Our nutrition experts are here to help you achieve your health goals.</p>
        <a href="pages/contact.php" class="home-contact-btn" aria-label="Contact our experts">
            <i class="fas fa-envelope"></i> Contact Our Experts
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>