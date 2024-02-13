<?php

require_once('../connect.php');

// medical staff archive function
$user_id = $_REQUEST['user_id'];

$query = "INSERT INTO medical_staff (user_id, first_name, last_name, email, pass, specialization, status) 
          SELECT user_id, first_name, last_name, email, pass, specialization, 'active' AS status
          FROM medical_staff_archive
          WHERE user_id='$user_id';";

if(mysqli_query($mysqli, $query)){
    $query = "DELETE FROM medical_staff_archive WHERE user_id='$user_id';";
    if(mysqli_query($mysqli, $query)){
        echo "<script>window.location.href='..?page=home&success=1';</script>";
    } else {
        echo "<script>window.location.href='..?page=home&error=1';</script>"; 
    }
} else {
    echo "<script>window.location.href='..?page=home&error=1';</script>";
}
?>
