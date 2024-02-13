<?php
// IMPORT CSV DATA

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
  $csvFile = $_FILES['csv_file']['tmp_name'];

  if (is_uploaded_file($csvFile)) {
    $csvData = array_map('str_getcsv', file($csvFile));

    $headers = array_shift($csvData);

    $connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
    $db = mysqli_select_db($connection, 'u868151448_pupmsd');

    foreach ($csvData as $row) {
      $medicine = mysqli_real_escape_string($connection, $row[1]); // Adjust column index

      // id should not be included here, starting from here lang may babaguhin...
      $query = "INSERT INTO medicine_inventory (
        date, 
        medicine, 
        quantity, 
        consumed, 
        expiration_date)
        VALUES (?, ?, ?, ?, ?)";

      $stmt = mysqli_prepare($connection, $query);

      mysqli_stmt_bind_param($stmt, "sssss", $row[0], $row[1], $row[2], $row[3], $row[4]);
      
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    // and up until here yung changes, end.


    // Close database connection
    mysqli_close($connection);

    echo "CSV data imported successfully.";
  } else {
    echo "Error uploading CSV file.";
  }
}
?>