<?php
session_start();
include 'includes/db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (!isset($_POST['weight']) || !is_numeric($_POST['weight']) ||
        !isset($_POST['height']) || !is_numeric($_POST['height']) ||
        !isset($_POST['age']) || !is_numeric($_POST['age']) ||
        !isset($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input values']);
        exit;
    }

    $weight = floatval($_POST['weight']);
    $height_cm = floatval($_POST['height']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $user_id = $_SESSION['user_id'];

    // Calculate BMI
    $height_m = $height_cm / 100; // Convert cm to meters
    $bmi = $weight / ($height_m * $height_m);

    // Calculate BMR (Mifflin-St Jeor Equation)
    if ($gender === 'male') {
        $bmr = 10 * $weight + 6.25 * $height_cm - 5 * $age + 5;
    } else {
        $bmr = 10 * $weight + 6.25 * $height_cm - 5 * $age - 161;
    }

    // Calculate nutrient needs
    $protein = $weight * 1.2; // 1.2g/kg for moderate activity
    $calcium = $age > 50 ? 1200 : 1000; // More for older adults
    $vitamin_c = $gender === 'male' ? 90 : 75;
    $vitamin_d = $age > 70 ? 20 : 15;
    $fiber = $gender === 'male' ? 30 : 25;
    $iron = $gender === 'male' ? 8 : 18;
    $magnesium = $gender === 'male' ? 420 : 320;
    $potassium = $gender === 'male' ? 3400 : 2600;
    $water = $weight * 35; // 35ml/kg

    // Store in database
    $stmt = $conn->prepare("INSERT INTO nutrition_needs (user_id, weight, height, age, gender, bmi, bmr, protein, calcium, vitamin_c, vitamin_d, fiber, iron, magnesium, potassium, water) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database preparation failed']);
        exit;
    }

    $stmt->bind_param("iddisdidiiiiiiii", $user_id, $weight, $height_cm, $age, $gender, $bmi, $bmr, $protein, $calcium, $vitamin_c, $vitamin_d, $fiber, $iron, $magnesium, $potassium, $water);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Database insertion failed']);
        exit;
    }

    // Return results
    echo json_encode([
        'bmi' => round($bmi, 1),
        'bmr' => round($bmr, 1) . ' kcal/day',
        'protein' => round($protein, 1) . 'g',
        'calcium' => $calcium . 'mg',
        'vitamin_c' => $vitamin_c . 'mg',
        'vitamin_d' => $vitamin_d . 'mcg',
        'fiber' => $fiber . 'g',
        'iron' => $iron . 'mg',
        'magnesium' => $magnesium . 'mg',
        'potassium' => $potassium . 'mg',
        'water' => $water . 'ml'
    ]);

    $stmt->close();
}

$conn->close();
?>