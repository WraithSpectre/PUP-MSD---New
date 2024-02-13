<?php

require_once('../connect.php');

$user_id = $_REQUEST['user_id'];


$query = "DELETE FROM medical_staff_archive WHERE user_id='$user_id';";

if(mysqli_query($mysqli,$query)){
        echo "<script>window.location.href='..?page=trash&delete=1';</script>"; 
}

else{

    echo "<script>window.location.href='..?page=trash&error=1';</script>";
 }

    



?>