<?php
include '../connect.php';

$sup_id = $_REQUEST['sup_id'];


$query = "INSERT INTO supply_inventory_archive (sup_id, date, supply, quantity, consumed, expiration_date)
          SELECT sup_id, date, supply, quantity, consumed, expiration_date
          FROM supply_inventory
          WHERE sup_id='$sup_id';";


if(mysqli_query($mysqli,$query)){

    $query = "DELETE FROM supply_inventory WHERE sup_id='$sup_id';";
    if(mysqli_query($mysqli,$query)){

    echo "<script>window.location.href='..?page=home&success=1';</script>";
    }

    else{
        echo "<script>window.location.href='..?page=home&error=1';</script>"; 
    }

}

else{

    echo "<script>window.location.href='..?page=home&error=1';</script>";
 }

?>