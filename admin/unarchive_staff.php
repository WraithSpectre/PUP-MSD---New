<?php

require_once('../connect.php');

$user_id = $_REQUEST['user_id'];


$query = "INSERT INTO medical_staff (user_id, first_name, last_name, email, pass, specialization) 
SELECT user_id, first_name, last_name, email, pass, specialization 
FROM medical_staff_archive WHERE user_id='$user_id';";

if(mysqli_query($mysqli,$query)){

    $query = "DELETE FROM medical_staff_archive WHERE user_id='$user_id';";
    if(mysqli_query($mysqli, $query)){

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