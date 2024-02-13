<?php
// INSERT DATA 

$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['insertdata'])) {
  $date = $_POST['date'];
  $clinic = $_POST['clinic'];
  $campus = $_POST['campus'];
  $medicines = $_POST['medicines'];
  $m_quantity = $_POST['m_quantity'];
  $m_date_received = $_POST['m_date_received'];
  $m_remarks = $_POST['m_remarks'];
  $supplies = $_POST['supplies'];
  $s_quantity = $_POST['s_quantity'];
  $s_date_received = $_POST['s_date_received'];
  $s_remarks = $_POST['s_remarks'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];
  $status = $_POST['status'];

  $query = "INSERT INTO tbl_supply 
    (`date`, `clinic`, `campus`, `medicines`, `m_quantity`, `m_date_received`, `m_remarks`, 
    `supplies`, `s_quantity`, `s_date_received`, `s_remarks`, `prepared_by`, `noted_by`, `status`) 
    VALUES 
    ('$date', '$clinic', '$campus', '$medicines', '$m_quantity', '$m_date_received', '$m_remarks', 
    '$supplies', '$s_quantity', '$s_date_received', '$s_remarks', '$prepared_by', '$noted_by', '$status')";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Saved");</script>';
    echo '<script>window.location.href = "supply.php";</script>';
  } else {
    echo '<script>alert("Data Not Saved");</script>';
    echo '<script>window.location.href = "supply.php";</script>';
  }

  exit();
}
?>



<?php
// UPDATE DATA 

$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['updatedata'])) {
  $id = $_POST['update_id'];

  $date = $_POST['date'];
  $clinic = $_POST['clinic'];
  $campus = $_POST['campus'];
  $medicines = $_POST['medicines'];
  $m_quantity = $_POST['m_quantity'];
  $m_date_received = $_POST['m_date_received'];
  $m_remarks = $_POST['m_remarks'];
  $supplies = $_POST['supplies'];
  $s_quantity = $_POST['s_quantity'];
  $s_date_received = $_POST['s_date_received'];
  $s_remarks = $_POST['s_remarks'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];
  $status = $_POST['status'];

  $query = "UPDATE tbl_supply SET 
    `date`='$date', 
    `clinic`='$clinic', 
    `campus`='$campus', 
    `medicines`='$medicines', 
    `m_quantity`='$m_quantity', 
    `m_date_received`='$m_date_received', 
    `m_remarks`='$m_remarks', 
    `supplies`='$supplies', 
    `s_quantity`='$s_quantity', 
    `s_date_received`='$s_date_received', 
    `s_remarks`='$s_remarks', 
    `prepared_by`='$prepared_by', 
    `noted_by`='$noted_by' 
    'status' = '$status';
    WHERE id='$id'  ";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Updated");</script>';
    echo '<script>window.location.href = "supply.php";</script>';
  } else {
    echo '<script>alert("Data Not Updated");</script>';
    echo '<script>window.location.href = "supply.php";</script>';
  }

  exit();
}
?>


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
      $name = mysqli_real_escape_string($connection, $row[0]); // Adjust column index

      $query = "INSERT INTO tbl_supply (
        medicines, 
        m_quantity, 
        m_date_received, 
        m_remarks, 
        supplies, 
        s_quantity, 
        s_date_received, 
        s_remarks,
        status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = mysqli_prepare($connection, $query);

      mysqli_stmt_bind_param($stmt, "sssssssss", $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
      
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }


    // Close database connection
    mysqli_close($connection);

    echo "CSV data imported successfully.";
  } else {
    echo "Error uploading CSV file.";
  }
}
?>