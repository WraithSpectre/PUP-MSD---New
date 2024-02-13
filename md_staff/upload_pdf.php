<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../connect.php'; // Include your database connection file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$patientId = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';

// Define the target directory for file uploads
$targetDir = "uploads/";

// Get the file name
$fileName = basename($_FILES["pdf_file"]["name"]);
$targetFilePath = $targetDir . $fileName;

// Check if file type is PDF


// Check if the file already exists
if (file_exists($targetFilePath)) {
    echo "File already exists.";
    exit;
}

// Check if the file was successfully uploaded
if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFilePath)) {
    // Update the pdf_path column in the database
    $patientId = $_POST['patient_id'];
    $updateSql = "UPDATE patient_information SET pdf_path = '$targetFilePath' WHERE patient_id = '$patientId'";

    if ($mysqli->query($updateSql) === true) {
        echo "Patient ID: " . $patientId;
        header("Location: patients.php");
        exit();
    } else {
        echo "Error updating database: " . $mysqli->error;
    }
}
}
else {
    echo "Error uploading file.";
}


// Close the database connection
$mysqli->close();
?>


