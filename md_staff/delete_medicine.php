<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $med_id = $_POST['med_id'];

    // Perform the deletion query
    $deleteMedicineQuery = "DELETE FROM medicine_inventory WHERE med_id = $med_id";
    if ($mysqli->query($deleteMedicineQuery)) {
        echo "Medicine deleted successfully.";
    } else {
        http_response_code(500);
        echo "Error deleting medicine: " . $mysqli->error;
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}

$mysqli->close();
?>
