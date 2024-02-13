<?php
// Include your database connection file
include '../connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data
    $treatment = $_POST['treatment'];
    $notes = $_POST['notes'];
    $status = $_POST['status'];
    $consultationId = $_POST['consultation_id'];

    // Update consultation data in the database
    $updateSql = "UPDATE consultation 
                  SET treatment = '$treatment', notes = '$notes', status = '$status' 
                  WHERE consultation_id = $consultationId";

    if ($mysqli->query($updateSql) === true) {
        echo "Consultation updated successfully.";
        
    } else {
        echo "Error updating consultation: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
