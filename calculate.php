<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Validate input
    if (!isset($_POST['weight']) || !is_numeric($_POST['weight'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid weight value']);
        exit;
    }

    $weight = floatval($_POST['weight']);
    
    // Perform calculations
    $protein = $weight * 0.8;
    $calcium = 1000;
    $vitaminC = 90;
    $vitaminD = 20;
    $fiber = 30;
    $iron = 8;
    $magnesium = 400;
    $potassium = 3500;
    $water = ($weight * 35);

    // Store in database
    $stmt = $conn->prepare("INSERT INTO users (weight, protein_needs, calcium_needs, vitaminC_needs, vitaminD_needs, fiber_needs, iron_needs, magnesium_needs, potassium_needs, water_needs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database preparation failed']);
        exit;
    }
    
    $stmt->bind_param("dddddddddd", $weight, $protein, $calcium, $vitaminC, $vitaminD, $fiber, $iron, $magnesium, $potassium, $water);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Database insertion failed']);
        exit;
    }
    
    // Return results
    echo json_encode([
        'protein' => $protein . 'g',
        'calcium' => $calcium . 'mg',
        'vitaminC' => $vitaminC . 'mg',
        'vitaminD' => $vitaminD . 'mcg',
        'fiber' => $fiber . 'g',
        'iron' => $iron . 'mg',
        'magnesium' => $magnesium . 'mg',
        'potassium' => $potassium . 'mg',
        'water' => $water . 'ml'
    ]);
}

//$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Calculator</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="assets/js/calculate.js" defer></script>
    <script src="../assets/js/calculate.js" defer></script>

</head>

<body>

</body>
</html>
