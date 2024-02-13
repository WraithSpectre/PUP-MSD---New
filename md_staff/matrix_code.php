<!-- INSERT DATA -->
<?php
$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['insertdata'])) {
  $name = $_POST['name'];
  $course = $_POST['course'];
  $age = $_POST['age'];
  $gender = isset($_POST['male']) ? $_POST['male'] : (isset($_POST['female']) ? $_POST['female'] : '');  
  $sc = $_POST['sc'];
  $pwd = $_POST['pwd'];
  $date_of_request = $_POST['date_of_request'];
  $date_acted_upon = $_POST['date_acted_upon'];
  $remarks = $_POST['remarks'];
  
  $clinic = $_POST['clinic'];
  $purpose = $_POST['purpose'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];


  $query = "INSERT INTO tbl_matrix 
    (`name`, `course`, `age`, `gender`, `sc`, `pwd`, `date_of_request`, `date_acted_upon`, `remarks`, 
    `clinic`, `purpose`, `month`, `year`, `prepared_by`, `noted_by`) 
    VALUES 
    ('$name', '$course', '$age', '$gender', '$sc', '$pwd', '$date_of_request', '$date_acted_upon', '$remarks', 
    '$clinic', '$purpose', '$month', '$year', '$prepared_by', '$noted_by')";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Updated");</script>';
    echo '<script>window.location.href = "matrix.php";</script>';
  } else {
    echo '<script>alert("Data Not Updated");</script>';
    echo '<script>window.location.href = "matrix.php";</script>';
  }
}
?>

<!-- UPDATE DATA -->
<?php
$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['updatedata'])) {
  $id = $_POST['update_id'];

  $name = $_POST['name'];
  $course = $_POST['course'];
  $age = $_POST['age'];
  $gender = isset($_POST['male']) ? $_POST['male'] : (isset($_POST['female']) ? $_POST['female'] : '');  
  $sc = $_POST['sc'];
  $pwd = $_POST['pwd'];
  $date_of_request = $_POST['date_of_request'];
  $date_acted_upon = $_POST['date_acted_upon'];
  $remarks = $_POST['remarks'];
  
  $clinic = $_POST['clinic'];
  $purpose = $_POST['purpose'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];

  $query = "UPDATE tbl_matrix SET 
    `name` = '$name',
    `course` = '$course',
    `age` = '$age',
    `gender` = '$gender',
    `sc` = '$sc',
    `pwd` = '$pwd',
    `date_of_request` = '$date_of_request',
    `date_acted_upon` = '$date_acted_upon',
    `remarks` = '$remarks',
    `clinic` = '$clinic',
    `purpose` = '$purpose',
    `month` = '$month',
    `year` = '$year',
    `prepared_by` = '$prepared_by',
    `noted_by` = '$noted_by'
    WHERE `id` = '$id'";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Updated");</script>';
    echo '<script>window.location.href = "matrix.php";</script>';
  } else {
    echo '<script>alert("Data Not Updated");</script>';
    echo '<script>window.location.href = "matrix.php";</script>';
  }
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

      $query = "INSERT INTO tbl_matrix (
        name, 
        course, 
        age, 
        gender, 
        sc, 
        pwd, 
        date_of_request, 
        date_acted_upon,
        remarks)
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
