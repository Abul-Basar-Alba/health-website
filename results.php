<?php
session_start();
include 'includes/index_header.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Check if results are available
if (!isset($_SESSION['nutrition_results'])) {
    header("Location: index.php");
    exit;
}

$results = $_SESSION['nutrition_results'];
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h1>Your Health and Nutrition Report</h1>
    
    <!-- Health Condition -->
    <div class="result-section">
        <h2>Health Condition</h2>
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

    <!-- Nutrient Needs -->
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

    <!-- Navigation to Nutrition Info -->
    <div class="cta-section">
        <h2>Learn More About Nutrition</h2>
        <p>Discover the importance of these nutrients and recommended foods to meet your needs.</p>
        <a href="pages/nutrition.php" class="home-contact-btn" aria-label="View nutrition information">
            <i class="fas fa-info-circle"></i> Explore Nutrition Guide
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>