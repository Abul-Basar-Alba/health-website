<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Welcome to Health Nutrition Guide</h1>
    <form id="healthForm" action="calculate.php" method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" required>
        <button type="submit">Calculate</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>