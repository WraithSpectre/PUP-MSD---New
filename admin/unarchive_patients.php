<?php

require_once('../connect.php');

$patient_id = $_REQUEST['patient_id'];


$query = "INSERT INTO patients (patient_id, first_name, last_name, date_of_birth, gender, address, contact_number, email, type, report_id) 
SELECT patient_id, first_name, last_name, date_of_birth, gender, address, contact_number, email, type, report_id FROM patients_archive WHERE patient_id='$patient_id';";

if(mysqli_query($mysqli,$query)){

    $query = "DELETE FROM patients_archive WHERE patient_id='$patient_id';";
    if(mysqli_query($mysqli,$query)){

    echo "<script>window.location.href='..?page=trash&success=1';</script>";
    }

    else{
        echo "<script>window.location.href='..?page=trash&error=1';</script>"; 
    }

}

else{

    echo "<script>window.location.href='..?page=trash&error=1';</script>";
 }

    



?>