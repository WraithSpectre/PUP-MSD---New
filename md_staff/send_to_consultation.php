<?php
// send_to_consultation.php

include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];

    // Perform necessary actions to send the patient to consultation
    // For example, you can update the database or perform any other business logic

    // After processing, you can send a response if needed
    echo json_encode(['success' => true]);
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}

// Close the database connection
$mysqli->close();
?>
