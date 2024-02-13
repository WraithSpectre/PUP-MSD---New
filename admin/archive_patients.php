<?php
include '../connect.php';

$patient_id = $_REQUEST['patient_id'];

// Use a parameterized query to prevent SQL injection
$query = "INSERT INTO patients_archive (patient_id, first_name, last_name, date_of_birth, gender, address, contact_number, email, type, report_id) SELECT patient_id, first_name, last_name, date_of_birth, gender, address, contact_number, email, type, report_id FROM patients WHERE patient_id = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $patient_id);

if ($stmt->execute()) {

    // Use a parameterized query to prevent SQL injection
    $deleteQuery = "DELETE FROM patients WHERE patient_id = ?";
    $stmtDelete = $mysqli->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $patient_id);

    if ($stmtDelete->execute()) {
        echo "<script>window.location.href='..?page=home&success=1';</script>";
    } else {
        echo "<script>window.location.href='..?page=home&error=1';</script>";
    }

} else {
    echo "<script>window.location.href='..?page=home&error=1';</script>";
}

// Close the prepared statements
$stmt->close();
$stmtDelete->close();

// Close the database connection
$mysqli->close();
?>