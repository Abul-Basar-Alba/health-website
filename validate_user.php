<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'];
    $value = $_POST['value'];

    if ($field === 'username' || $field === 'email') {
        $sql = "SELECT * FROM users WHERE $field = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();

        echo json_encode(['exists' => $result->num_rows > 0]);
    } else {
        echo json_encode(['exists' => false]);
    }
}
?>
