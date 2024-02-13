<?php
// INSERT DATA 

$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

if (isset($_POST['insertdata'])) {
  $general_description = isset($_POST['general_description']) ? $_POST['general_description'] : '';
  $custom_description = isset($_POST['request']) ? $_POST['request'] : ''; 
  $is_custom_description = isset($_POST['custom_description']) && $_POST['custom_description'] === '0';
  $quantity = $_POST['quantity']; 
  $serviceable = isset($_POST['serviceable']) ? 1 : 0; // If the checkbox is checked, set to 1; otherwise, set to 0
  $nonserviceable = isset($_POST['nonserviceable']) ? 1 : 0;
  $nonserviceable_option = isset($_POST['nonserviceable_option']) ? $_POST['nonserviceable_option'] : '';
  $need_replacement = isset($_POST['need_replacement']) ? 1 : 0;
  $additional = isset($_POST['additional']) ? 1 : 0;
  $quantity_of_request = $_POST['quantity_of_request'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $date = $_POST['date'];
  $submitted_by_1 = $_POST['submitted_by_1'];
  $submitted_by_2 = $_POST['submitted_by_2'];


  $final_description = ($custom_description !== '') ? $custom_description : $general_description;

  
  $is_custom_description = (in_array($final_description, array(
    'Stethoscope',
    'Sphygmomanometer, table, aneroid',
    'Sphygmomanometer, pocket, aneroid',
    'Sphygmomanometer with stand',
    'Oto-ophthalmoscope set',
    'Thermal Scanner',
    'Thermoscan (Infared) with stand',
    'Nebulizer',
    'Manual resuscitator, adult',
    'Minor surgical set',
    'Aluminum tray with cover',
    'Aluminum kidney basin',
    'Oval magnifying lamp with stand',
    'Finger pulse oximeter',
    'Oxygen tank with regulator',
    'Oxygen tank (reserved)',
    'Oxygen tank carrier',
    'Portable Oxygen tank with regulator',
    'Glucometer',
    'Stretcher, folding',
    'Wheelchair',
    'Emergency Trauma Bag',
    'Dressing cart',
    'Hospital bed with mattress',
    'Medicine cabinet',
    'Weighing Scare unit height and bar type',
    'Spine board',
    'ECG machine',
    'Ice cap',
    'Ice pack (coleman)',
    'Ice chest',
    'Hot water bag',
    'Towels for ice pack/ice cap',
    'Bedsheets and pillow cases',
    'Blankets/ linens',
    'Pillows',
    'Autoclave',
    'Sterilizer',
    'First Aid Kit Bag (PHN)',
    'Electric airpot',
    'Computer',
    'Printer',
    'Air Purifier',
    'Ultraviolet Disinfection Light',
    'Shredder',
    'Folding Bed (Military Style with Bag)',
    'Industrial Fan (Iwata) Tripod Feet',
    'Standard Exhaust Fan',
  )) === false);

  $query = "INSERT INTO tbl_equipments 
    (`general_description`, `quantity`, `serviceable`, `nonserviceable`, `nonserviceable_option`, 
    `need_replacement`, `additional`, `quantity_of_request`, `month`, `year`, `date`, `submitted_by_1`, `submitted_by_2`) 
    VALUES 
    ('$final_description', '$quantity', '$serviceable', '$nonserviceable', '$nonserviceable_option', 
    '$need_replacement', '$additional', '$quantity_of_request', '$month', '$year', '$date', '$submitted_by_1', '$submitted_by_2')";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Saved");</script>';
    echo '<script>window.location.href = "equipments.php";</script>';
  } else {
    echo '<script>alert("Data Not Saved");</script>';
    echo '<script>window.location.href = "equipments.php";</script>';
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

  $general_description = ($_POST['general_description']) ? $_POST['general_description'] : '';
  $custom_description = ($_POST['request']) ? $_POST['request'] : ''; 
  $is_custom_description = ($_POST['custom_description']) && $_POST['custom_description'] === '0';   $quantity = $_POST['quantity'];
  $quantity = $_POST['quantity'];
  $serviceable = $_POST['serviceable'] ? 1 : 0;
  $nonserviceable = $_POST['nonserviceable'] ? 1 : 0;
  $nonserviceable_option = $_POST['nonserviceable_option'] ? $_POST['nonserviceable_option'] : '';
  $need_replacement = $_POST['need_replacement'] ? 1 : 0;
  $additional = $_POST['additional'] ? 1 : 0;
  $quantity_of_request = $_POST['quantity_of_request'];
  
  $month = $_POST['month'];
  $year = $_POST['year'];
  $date = $_POST['date'];
  $submitted_by_1 = $_POST['submitted_by_1'];
  $submitted_by_2 = $_POST['submitted_by_2'];

  $final_description = ($general_description === '' && $custom_description !== '') ? $custom_description : $general_description;

  $is_custom_description = (in_array($final_description, array(
    'Stethoscope',
    'Sphygmomanometer, table, aneroid',
    'Sphygmomanometer, pocket, aneroid',
    'Sphygmomanometer with stand',
    'Oto-ophthalmoscope set',
    'Thermal Scanner',
    'Thermoscan (Infared) with stand',
    'Nebulizer',
    'Manual resuscitator, adult',
    'Minor surgical set',
    'Aluminum tray with cover',
    'Aluminum kidney basin',
    'Oval magnifying lamp with stand',
    'Finger pulse oximeter',
    'Oxygen tank with regulator',
    'Oxygen tank (reserved)',
    'Oxygen tank carrier',
    'Portable Oxygen tank with regulator',
    'Glucometer',
    'Stretcher, folding',
    'Wheelchair',
    'Emergency Trauma Bag',
    'Dressing cart',
    'Hospital bed with mattress',
    'Medicine cabinet',
    'Weighing Scare unit height and bar type',
    'Spine board',
    'ECG machine',
    'Ice cap',
    'Ice pack (coleman)',
    'Ice chest',
    'Hot water bag',
    'Towels for ice pack/ice cap',
    'Bedsheets and pillow cases',
    'Blankets/ linens',
    'Pillows',
    'Autoclave',
    'Sterilizer',
    'First Aid Kit Bag (PHN)',
    'Electric airpot',
    'Computer',
    'Printer',
    'Air Purifier',
    'Ultraviolet Disinfection Light',
    'Shredder',
    'Folding Bed (Military Style with Bag)',
    'Industrial Fan (Iwata) Tripod Feet',
    'Standard Exhaust Fan',
  )) === false);

  $query = "UPDATE tbl_equipments SET 
    `general_description`='$final_description', 
    `quantity`='$quantity', 
    `serviceable`='$serviceable', 
    `nonserviceable`='$nonserviceable', 
    `nonserviceable_option`='$nonserviceable_option', 
    `need_replacement`='$need_replacement', 
    `additional`='$additional', 
    `quantity_of_request`='$quantity_of_request',
    `month`='$month', 
    `year`='$year',
    `date`='$date', 
    `submitted_by_1`='$submitted_by_1', 
    `submitted_by_2`='$submitted_by_2'
    WHERE id='$id'  ";

  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo '<script>alert("Data Updated");</script>';
    echo '<script>window.location.href = "equipments.php";</script>';
  } else {
    echo '<script>alert("Data Not Updated");</script>';
    echo '<script>window.location.href = "equipments.php";</script>';
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

      $query = "INSERT INTO tbl_equipments (
        general_description, 
        quantity, 
        serviceable, 
        nonserviceable, 
        nonserviceable_option, 
        need_replacement, 
        additional, 
        quantity_of_request)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = mysqli_prepare($connection, $query);

      mysqli_stmt_bind_param($stmt, "ssssssss", $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]);
      
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