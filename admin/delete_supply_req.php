<?php
$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs", "u868151448_pupmsd");
if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $query = "DELETE FROM tbl_supply WHERE id = '$id'";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo 'success';
  } else {
    echo 'error';
  }
}
?>