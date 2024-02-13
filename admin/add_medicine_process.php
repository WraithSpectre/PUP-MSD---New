<?php

include '../connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data here
    $date = $_POST['date'];
    $medicine = $_POST['medicine'];
    $quantity = $_POST['$quantity'];
    $consumed = $_POST['$consumed'];
    $expiration_date = $_POST['$expiration_date'];

    // Insert new patient into the database
    $insert_sql = "INSERT INTO supply_inventory (med_id, date, medicine, quantity, consumed, expiration_date) 
                    VALUES ('$med_id', '$date', '$medicine', '$quantiy', '$consumed', '$expiration_date')";

    if ($mysqli->query($insert_sql) === true) {
        // Redirect or display a success message after adding the patient
        // header("Location: patients.php"); // Uncomment and modify as needed
        // After successfully adding a patient
        header("Location: supplies.php");
        exit();
    } else {
        die("Error: " . $connection->error);
    }
}
?>