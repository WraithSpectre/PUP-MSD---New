<?php

include '../connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data here
    $date = $_POST['date'];
    $supply = $_POST['supply'];
    $quantity = $_POST['$quantity'];
    $consumed = $_POST['$consumed'];
    $expiration_date = $_POST['$expiration_date'];

    // Insert new patient into the database
    $insert_sql = "INSERT INTO supply_inventory (sup_id, date, supply, quantity, consumed, expiration_date) 
                    VALUES ('$sup_id', '$date', '$supply', '$quantiy', '$consumed', '$expiration_date')";

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