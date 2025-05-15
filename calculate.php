<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input validation
    if (!isset($_POST['weight']) || !is_numeric($_POST['weight']) ||
        !isset($_POST['height']) || !is_numeric($_POST['height']) ||
        !isset($_POST['age']) || !is_numeric($_POST['age']) ||
        !isset($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female'])) {
        $_SESSION['error'] = "Invalid input values";
        header("Location: home.php");
        exit;
    }

    $weight = floatval($_POST['weight']);
    $height_cm = floatval($_POST['height']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    // Calculate BMI
    $height_m = $height_cm / 100;
    $bmi = $weight / ($height_m * $height_m);

    // Determine health condition
    $health_condition = '';
    if ($bmi < 18.5) {
        $health_condition = "Underweight";
    } elseif ($bmi >= 18.5 && $bmi < 25) {
        $health_condition = "Normal weight";
    } elseif ($bmi >= 25 && $bmi < 30) {
        $health_condition = "Overweight";
    } else {
        $health_condition = "Obese";
    }

    // Calculate BMR (Mifflin-St Jeor Equation)
    if ($gender === 'male') {
        $bmr = 10 * $weight + 6.25 * $height_cm - 5 * $age + 5;
    } else {
        $bmr = 10 * $weight + 6.25 * $height_cm - 5 * $age - 161;
    }

    // Calculate nutrient needs
    $protein = $weight * 1.2;
    $calcium = $age > 50 ? 1200 : 1000;
    $vitamin_c = $gender === 'male' ? 90 : 75;
    $vitamin_d = $age > 70 ? 20 : 15;
    $fiber = $gender === 'male' ? 30 : 25;
    $iron = $gender === 'male' ? 8 : 18;
    $magnesium = $gender === 'male' ? 420 : 320;
    $potassium = $gender === 'male' ? 3400 : 2600;
    $water = $weight * 35;

    // Store in database
    $stmt = $conn->prepare("INSERT INTO nutrition_needs (user_id, weight, height, age, gender, bmi, bmr, protein, calcium, vitamin_c, vitamin_d, fiber, iron, magnesium, potassium, water) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = "Database preparation failed: " . $conn->error;
        header("Location: home.php");
        exit;
    }

    $stmt->bind_param("iddisdidiiiiiiii", $user_id, $weight, $height_cm, $age, $gender, $bmi, $bmr, $protein, $calcium, $vitamin_c, $vitamin_d, $fiber, $iron, $magnesium, $potassium, $water);
    if (!$stmt->execute()) {
        $_SESSION['error'] = "Database insertion failed: " . $stmt->error;
        header("Location: home.php");
        exit;
    }

    $stmt->close();

    // Store results in session
    $_SESSION['nutrition_results'] = [
        'user_id' => $user_id,
        'weight' => $weight,
        'height' => $height_cm,
        'age' => $age,
        'gender' => $gender,
        'bmi' => round($bmi, 1),
        'health_condition' => $health_condition,
        'bmr' => round($bmr, 1),
        'protein' => round($protein, 1),
        'calcium' => $calcium,
        'vitamin_c' => $vitamin_c,
        'vitamin_d' => $vitamin_d,
        'fiber' => $fiber,
        'iron' => $iron,
        'magnesium' => $magnesium,
        'potassium' => $potassium,
        'water' => $water
    ];

    header("Location: pages/results.php");
    exit;
}

$conn->close();
?>