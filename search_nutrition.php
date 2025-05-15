<?php
session_start();
include '../includes/header.php';

$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("SELECT * FROM nutrition_needs WHERE user_id = ? AND weight = ? AND height = ? AND age = ? AND gender = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: search_nutrition.php");
        exit;
    }
    $stmt->bind_param("iddis", $user_id, $weight, $height, $age, $gender);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>

<div class="container">
    <h1>Search Nutrition Records</h1>
    
    <form action="search_nutrition.php" method="POST">
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="number" id="user_id" name="user_id" min="1" required class="form-control">
        </div>
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
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if (!empty($results)): ?>
        <h2>Search Results</h2>
        <?php foreach ($results as $record): ?>
            <div class="result-section">
                <h3>Record for User ID: <?php echo htmlspecialchars($record['user_id']); ?></h3>
                <p><strong>Weight:</strong> <?php echo $record['weight']; ?> kg</p>
                <p><strong>Height:</strong> <?php echo $record['height']; ?> cm</p>
                <p><strong>Age:</strong> <?php echo $record['age']; ?></p>
                <p><strong>Gender:</strong> <?php echo ucfirst($record['gender']); ?></p>
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
                <p><strong>Calculated on:</strong> <?php echo $record['created_at']; ?></p>
                <a href="nutrition.php" class="home-contact-btn">Explore Nutrition Guide</a>
            </div>
        <?php endforeach; ?>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No records found for the provided details.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>