<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    
    // Store in database
    $stmt = $conn->prepare("INSERT INTO users (weight, protein_needs, calcium_needs) VALUES (?, ?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database preparation failed']);
        exit;
    }
    
    $stmt->bind_param("ddd", $weight, $protein, $calcium);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => 'Database insertion failed']);
        exit;
    }
    
    // Return results
    echo json_encode([
        'protein' => $protein,
        'calcium' => $calcium
    ]);
}
?>