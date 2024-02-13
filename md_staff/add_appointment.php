<?php
include '../connect.php'; // This file should contain the database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data for adding an appointment
    $bloodPressure = isset($_POST['blood_pressure']) ? $_POST['blood_pressure'] : '';
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';
    $complaint = isset($_POST['complaint']) ? $_POST['complaint'] : '';
    $appointmentDate = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : '';
    $appointmentTime = isset($_POST['appointment_time']) ? $_POST['appointment_time'] : '';
    $staffInCharge = isset($_POST['staff_in_charge']) ? $_POST['staff_in_charge'] : '';
    $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';

    // Insert appointment details into the database
    $insertSql = "INSERT INTO appointments (blood_pressure, temperature, complaint, appointment_date, appointment_time, staff_in_charge, patient_id) 
                  VALUES ('$bloodPressure', '$temperature', '$complaint', '$appointmentDate', '$appointmentTime', '$staffInCharge', '$patientId')";

    if ($mysqli->query($insertSql) === true) {
        // Redirect or display a success message after adding the appointment
        header("Location: appointments.php");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}
?>

