<?php include 'includes/index_header.php'; ?>

<div class="container">

    <h1>Welcome to Health Nutrition Guide</h1>
    <form id="healthForm" action="calculate.php" method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" required>
        <button type="submit" aria-label="Calculate nutrient needs">Calculate</button>
    </form>
    
    <div class="cta-section">
        <h2>Need Personalized Advice?</h2>
        <p>Our nutrition experts are here to help you achieve your health goals.</p>
        <a href="pages/contact.php" class="home-contact-btn" aria-label="Contact our experts">
            <i class="fas fa-envelope"></i> Contact Our Experts
        </a>
    </div>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</div>

<?php include 'includes/footer.php'; ?>