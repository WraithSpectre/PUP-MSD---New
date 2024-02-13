<?php
// Include the database connection code
include '../connect.php';

// Check if the connection is successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the patient_id is set in the POST request
if (isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];

    // Delete the patient from the database
    $deleteSql = "DELETE FROM patients WHERE patient_id = '$patientId'";

    if ($mysqli->query($deleteSql) === true) {
        // Return a success message or any other response if needed
        echo "Record deleted successfully";
    } else {
        // Return an error message or any other response if needed
        echo "Error deleting record: " . $mysqli->error;
    }
} else {
    // Return an error message if patient_id is not set in the POST request
    echo "Patient ID not provided";
}

// Close the database connection
$mysqli->close();
?>