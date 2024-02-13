<!-- INSERT DATA -->
<?php
$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/md_staff/uploads';

// Check if the folder doesn't exist
if (!file_exists($uploadFolder)) {
  // Create the folder with read and write permissions for everyone
  mkdir($uploadFolder, 0777, true);
  error_log('Folder "uploads" created successfully.');
} else {
  error_log('Folder "uploads" already exists.');
}

$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['insertdata'])) {
  $name = $_POST['name'];
  $course = $_POST['course'];
  $age = $_POST['age'];
  $gender = isset($_POST['male']) ? $_POST['male'] : (isset($_POST['female']) ? $_POST['female'] : '');  $sc = $_POST['sc'];
  $pwd = $_POST['pwd'];
  $date_of_request = $_POST['date_of_request'];
  $date_acted_upon = $_POST['date_acted_upon'];

  // Handle file upload for the signature
  $signature = ''; // Initialize the variable
  if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
    $signature_tmp = $_FILES['signature']['tmp_name'];
    $signature_name = $_FILES['signature']['name'];
    $uploadFolder = 'md_staff/uploads'; // Adjust the folder name
    $signature = $uploadFolder . '/' . $signature_name; // Adjust the folder name
    move_uploaded_file($signature_tmp, $signature);
  }

  // Handle file upload for the md_signature
  $md_signature = ''; // Initialize the variable
  if (isset($_FILES['md_signature']) && $_FILES['md_signature']['error'] === UPLOAD_ERR_OK) {
    $md_signature_tmp = $_FILES['md_signature']['tmp_name'];
    $md_signature_name = $_FILES['md_signature']['name'];
    $uploadFolder = 'md_staff/uploads'; // Adjust the folder name
    $md_signature = $uploadFolder . '/' . $md_signature_name; // Adjust the folder name
    move_uploaded_file($md_signature_tmp, $md_signature);
  }

  $remarks = $_POST['remarks'];
  $clinic = $_POST['clinic'];
  $purpose = $_POST['purpose'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];


  $query = "INSERT INTO tbl_matrix_findings 
    (`name`, `course`, `age`, `gender`, `sc`, `pwd`, `date_of_request`, `date_acted_upon`, `signature`, `md_signature`, `remarks`,
    `clinic`, `purpose`, `month`, `year`, `prepared_by`, `noted_by`) 
    VALUES 
    ('$name', '$course', '$age', '$gender', '$sc', '$pwd', '$date_of_request', '$date_acted_upon', '$signature', '$md_signature', '$remarks',
    '$clinic', '$purpose', '$month', '$year', '$prepared_by', '$noted_by')";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script> alert("Data Saved"); </script>';
    header('Location: matrix_findings.php');
  } else {
    echo '<script> alert("Data Not Saved"); </script>';
  }
}
?>


<!-- UPDATE DATA -->
<?php
$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/md_staff/uploads';

// Check if the folder doesn't exist
if (!file_exists($uploadFolder)) {
  // Create the folder with read and write permissions for everyone
  mkdir($uploadFolder, 0777, true);
  error_log('Folder "uploads" created successfully.');
} else {
  error_log('Folder "uploads" already exists.');
}

$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['updatedata'])) {
  $id = $_POST['update_id'];

  $name = $_POST['name'];
  $course = $_POST['course'];
  $age = $_POST['age'];
  $gender = isset($_POST['male']) ? $_POST['male'] : (isset($_POST['female']) ? $_POST['female'] : '');  $sc = $_POST['sc'];
  $pwd = $_POST['pwd'];
  $date_of_request = $_POST['date_of_request'];
  $date_acted_upon = $_POST['date_acted_upon'];

  // Handle file upload for the signature
  $signature = ''; // Initialize the variable
  if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
    $signature_tmp = $_FILES['signature']['tmp_name'];
    $signature_name = $_FILES['signature']['name'];
    $uploadFolder = 'md_staff/uploads'; // Adjust the folder name
    $signature = $uploadFolder . '/' . $signature_name; // Adjust the folder name
    move_uploaded_file($signature_tmp, $signature);
    echo "Signature Path: $signature";
  }
  // Check if the signature field should be updated
  $signature_update = !empty($signature) ? "`signature` = '$signature'," : '';

  // Handle file upload for the md_signature
  $md_signature = ''; // Initialize the variable
  if (isset($_FILES['md_signature']) && $_FILES['md_signature']['error'] === UPLOAD_ERR_OK) {
    $md_signature_tmp = $_FILES['md_signature']['tmp_name'];
    $md_signature_name = $_FILES['md_signature']['name'];
    $uploadFolder = 'md_staff/uploads'; // Adjust the folder name
    $md_signature = $uploadFolder . '/' . $md_signature_name; // Adjust the folder name
    move_uploaded_file($md_signature_tmp, $md_signature);
    echo "MD Signature Path: $md_signature";
  }
  // Check if the signature field should be updated
  $md_signature_update = !empty($md_signature) ? "`md_signature` = '$md_signature'," : '';

  $remarks = $_POST['remarks'];
  $clinic = $_POST['clinic'];
  $purpose = $_POST['purpose'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $prepared_by = $_POST['prepared_by'];
  $noted_by = $_POST['noted_by'];


  $query = "UPDATE tbl_matrix_findings SET 
    `name` = '$name',
    `course` = '$course',
    `age` = '$age',
    `gender` = '$gender',
    `sc` = '$sc',
    `pwd` = '$pwd',
    `date_of_request` = '$date_of_request',
    `date_acted_upon` = '$date_acted_upon',
    $signature_update
    $md_signature_update
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
    echo '<script> alert("Data Updated"); </script>';
    header("Location: matrix_findings.php");
  } else {
    echo '<script> alert("Data Not Updated"); </script>';
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

      $query = "INSERT INTO tbl_matrix_findings (
        name, 
        course, 
        age, 
        gender, 
        sc, 
        pwd, 
        date_of_request, 
        date_acted_upon,
        signature,
        md_signature,
        remarks)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        

      $stmt = mysqli_prepare($connection, $query);

      mysqli_stmt_bind_param($stmt, "sssssssssss", $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
      
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
