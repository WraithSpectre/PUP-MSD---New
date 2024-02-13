<?php

require_once('../connect.php');

$sup_id = $_REQUEST['sup_id'];


$query = "INSERT INTO supply_inventory (sup_id, date, supply, quantity, consumed, expiration_date) 
SELECT sup_id, date, supply, quantity, consumed, expiration_date
FROM supply_inventory_archive WHERE sup_id='$sup_id';";

if(mysqli_query($mysqli,$query)){

    $query = "DELETE FROM supply_inventory_archive WHERE sup_id='$sup_id';";
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