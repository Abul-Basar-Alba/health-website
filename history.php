<?php
session_start();
include 'includes/header.php';

include 'includes/db_connect.php'; // ডাটাবেস কানেকশন যোগ করা হয়েছে
$records = [];
if (isset($_SESSION['id'])) {
    $stmt = $conn->prepare("SELECT * FROM nutrition_needs WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>
<link rel="stylesheet" href="../assets/css/history.css">
<main>
    <div class="history-section">
        <h1>Your Nutrition History</h1>
        
        <?php if (!empty($records)): ?>
            <?php foreach ($records as $record): ?>
                <div class="result-section">
                    <h3>Record from <?php echo $record['created_at']; ?></h3>
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars($record['user_id']); ?></p>
                    <p><strong>Weight:</strong> <?php echo $record['weight']; ?> kg</p>
                    <p><strong>Height:</strong> <?php echo $record['height']; ?> cm</p>
                    <p><strong>Age:</strong> <?php echo $record['age']; ?></p>
                    <p><strong>Gender:</strong> <?php echo ucfirst($record['gender']); ?></p>
                    <p><strong>Activity Level:</strong> <?php echo ucfirst(str_replace('_', ' ', $record['activity_level'])); ?></p>
                    <p><strong>BMI:</strong> <?php echo $record['bmi']; ?></p>
                    <p><strong>Health Status:</strong> 
                        <?php
                        $bmi = $record['bmi'];
                        if ($bmi < 18.5) {
                            echo "Underweight";
                        } elseif ($bmi >= 18.5 && $bmi < 25) {
                            echo "Normal weight";
                        } elseif ($bmi >= 25 && $bmi < 30) {
                            echo "Overweight";
                        } else {
                            echo "Obese";
                        }
                        ?>
                    </p>
                    <p><strong>BMR:</strong> <?php echo $record['bmr']; ?> kcal/day</p>
                    <p><strong>Total Daily Calories (TDEE):</strong> <?php echo $record['total_calories']; ?> kcal/day</p>
                    <h4>Daily Nutrient Needs</h4>
                    <table class="nutrient-table">
                        <tr>
                            <th>Nutrient</th>
                            <th>Amount</th>
                            <th>Unit</th>
                        </tr>
                        <tr>
                            <td>Protein</td>
                            <td><?php echo $record['protein']; ?></td>
                            <td>grams</td>
                        </tr>
                        <tr>
                            <td>Calcium</td>
                            <td><?php echo $record['calcium']; ?></td>
                            <td>mg</td>
                        </tr>
                        <tr>
                            <td>Vitamin C</td>
                            <td><?php echo $record['vitamin_c']; ?></td>
                            <td>mg</td>
                        </tr>
                        <tr>
                            <td>Vitamin D</td>
                            <td><?php echo $record['vitamin_d']; ?></td>
                            <td>mcg</td>
                        </tr>
                        <tr>
                            <td>Fiber</td>
                            <td><?php echo $record['fiber']; ?></td>
                            <td>grams</td>
                        </tr>
                        <tr>
                            <td>Iron</td>
                            <td><?php echo $record['iron']; ?></td>
                            <td>mg</td>
                        </tr>
                        <tr>
                            <td>Magnesium</td>
                            <td><?php echo $record['magnesium']; ?></td>
                            <td>mg</td>
                        </tr>
                        <tr>
                            <td>Potassium</td>
                            <td><?php echo $record['potassium']; ?></td>
                            <td>mg</td>
                        </tr>
                        <tr>
                            <td>Water</td>
                            <td><?php echo $record['water']; ?></td>
                            <td>ml</td>
                        </tr>
                    </table>
                    <a href="/pages/nutrition.php" class="home-contact-btn">Explore Nutrition Guide</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No nutrition records found. Please calculate your needs on the <a href="../home.php">home page</a>.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>