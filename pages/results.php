<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['nutrition_results'])) {
    header("Location: ../home.php");
    exit;
}

$results = $_SESSION['nutrition_results'];
?>

<div class="container">
    <h1>Your Health and Nutrition Report</h1>
    
    <div class="result-section">
        <h2>Health Condition</h2>
        <?php if ($results['user_id']): ?>
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($results['user_id']); ?></p>
        <?php endif; ?>
        <p><strong>Weight:</strong> <?php echo $results['weight']; ?> kg</p>
        <p><strong>Height:</strong> <?php echo $results['height']; ?> cm</p>
        <p><strong>Age:</strong> <?php echo $results['age']; ?></p>
        <p><strong>Gender:</strong> <?php echo ucfirst($results['gender']); ?></p>
        <p><strong>BMI:</strong> <?php echo $results['bmi']; ?></p>
        <p><strong>Health Status:</strong> <?php echo $results['health_condition']; ?></p>
        <p><strong>BMR (Basal Metabolic Rate):</strong> <?php echo $results['bmr']; ?> kcal/day</p>
        <?php
        $bmi_message = '';
        if ($results['health_condition'] == 'Underweight') {
            $bmi_message = "You may need to increase your calorie intake with nutrient-rich foods to reach a healthy weight.";
        } elseif ($results['health_condition'] == 'Normal weight') {
            $bmi_message = "Great job! Maintain a balanced diet to stay in this healthy range.";
        } elseif ($results['health_condition'] == 'Overweight') {
            $bmi_message = "Consider a balanced diet and regular exercise to reach a healthier weight.";
        } else {
            $bmi_message = "Consult a healthcare professional to develop a plan for weight management.";
        }
        ?>
        <p><strong>Recommendation:</strong> <?php echo $bmi_message; ?></p>
    </div>

    <div class="result-section">
        <h2>Daily Nutrient Needs</h2>
        <table class="nutrient-table">
            <tr>
                <th>Nutrient</th>
                <th>Amount</th>
                <th>Unit</th>
            </tr>
            <tr>
                <td>Protein</td>
                <td><?php echo $results['protein']; ?></td>
                <td>grams</td>
            </tr>
            <tr>
                <td>Calcium</td>
                <td><?php echo $results['calcium']; ?></td>
                <td>mg</td>
            </tr>
            <tr>
                <td>Vitamin C</td>
                <td><?php echo $results['vitamin_c']; ?></td>
                <td>mg</td>
            </tr>
            <tr>
                <td>Vitamin D</td>
                <td><?php echo $results['vitamin_d']; ?></td>
                <td>mcg</td>
            </tr>
            <tr>
                <td>Fiber</td>
                <td><?php echo $results['fiber']; ?></td>
                <td>grams</td>
            </tr>
            <tr>
                <td>Iron</td>
                <td><?php echo $results['iron']; ?></td>
                <td>mg</td>
            </tr>
            <tr>
                <td>Magnesium</td>
                <td><?php echo $results['magnesium']; ?></td>
                <td>mg</td>
            </tr>
            <tr>
                <td>Potassium</td>
                <td><?php echo $results['potassium']; ?></td>
                <td>mg</td>
            </tr>
            <tr>
                <td>Water</td>
                <td><?php echo $results['water']; ?></td>
                <td>ml</td>
            </tr>
        </table>
    </div>

    <div class="cta-section">
        <h2>Learn More About Nutrition</h2>
        <p>Discover the importance of these nutrients and recommended foods to meet your needs.</p>
        <a href="nutrition.php" class="home-contact-btn" aria-label="View nutrition information">
            <i class="fas fa-info-circle"></i> Explore Nutrition Guide
        </a>
        <a href="../history.php" class="home-contact-btn" aria-label="Lock your history">
            <i class="fas fa-history"></i> View Your History
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>