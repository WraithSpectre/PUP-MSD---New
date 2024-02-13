<?php
// Include the database connection code
include '../connect.php';

// Check if the patient ID is set in the POST request
if (isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];
    

    // Fetch the PDF path based on the patient ID
    $sql = "SELECT pdf_path FROM patient_information WHERE patient_id = $patientId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array('pdf_path' => $row['pdf_path']);
        echo json_encode($response);
    } else {
        echo json_encode(array('pdf_path' => null));
    }
} else {
    echo json_encode(array('pdf_path' => null));
}

// Close the database connection
$mysqli->close();
?>
