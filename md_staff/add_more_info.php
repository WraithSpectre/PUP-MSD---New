<?php
// Include your database connection file
include '../connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data
    $additionalInfo = $_POST['additional_info'];
    $contactPerson = $_POST['contact_person'];
    $contactPersonNumber = $_POST['contact_person_number'];
    $patientId = $_POST['patient_id'];
    
    
    

     // Insert additional information into the database
     $insertSql = "INSERT INTO patient_information (patient_id, additional_info, contact_person, contact_person_number) 
     VALUES ('$patientId', '$additionalInfo', '$contactPerson', '$contactPersonNumber')";

if ($mysqli->query($insertSql) === true) {
// Redirect or display a success message after adding additional information
// header("Location: patients.php"); // Uncomment and modify as needed
} else {
die("Error: " . $mysqli->error);
}

  
}


// Close the database connection
$mysqli->close();
?>

