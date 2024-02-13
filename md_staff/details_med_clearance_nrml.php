<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'public_html');

$query = "SELECT * FROM tbl_matrix";
$query_run = mysqli_query($connection, $query);

if ($query_run) {
    $row = mysqli_fetch_assoc($query_run);
    $clinic = $row['clinic'];
    $purpose = $row['purpose'];
    $month_yr = $row['month_yr'];
    $prepared_by = $row['prepared_by'];
    $noted_by = $row['noted_by'];
} else {
    echo "Error fetching data from the database.";
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Clearance PDF</title>
</head>
<body>
    <header>
    <img src="/styles/pup-logo2.png" alt="" class="logo">
    <h4 style="text-align: center; margin: 0.5px;">Republic of the Philippines</h4>
    <h4 style="text-align: center; margin: 0.5px;">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h4>
    <h4 style="text-align: center; margin: 0.5px;">Manila</h4>
    <br>
    <b><h3 style="text-align: center; margin: 0.5px">MEDICAL CLEARANCE</h3></b>
    <h5 style="text-align: right; margin-right: 221.5px;">Date: <span id="currentDate"></span></h5>
    </header>
    <br>
    <p style="text-align: left; margin: 0.5px"> To Whom It May Concern: </p>
    <p style="text-align: left; margin: 15px">This is to certify that <?php?></p>
    <p style="text-align: left; margin: 0.5px">has been examined by the undersigned and found to be physically fit at the time of</p>
    <p style="text-align: left; margin: 0.5px">examination.</p>

    <br>

    <p style="text-align: left; margin: 15px">This certification is issued upon his/her request for <?php echo $request?> purpose but not for medico-legal reason.</p>
    <br>
    <br>
    <p style="text-align: right; margin: 15px"><?php echo $noted_by; ?>M.D</p>
    <p style="text-align: right; margin: 15px">Lic. No.<?php echo $lic_no; ?></p>



    <script>
        // Get current date
        var currentDate = new Date();

        // Format the date as desired
        var formattedDate = currentDate.toDateString(); // Example: Sun Feb 14 2024

        // Display the date in the HTML element with id "currentDate"
        document.getElementById('currentDate').innerHTML = formattedDate;
    </script>
</body>
</html>