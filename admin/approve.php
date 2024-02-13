<?php
$connection = mysqli_connect("localhost", "root", "", "public_html");
if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $query = "UPDATE tbl_supply SET status = 'Approved' WHERE id = '$id'";
  $query_run = mysqli_query($connection, $query);

  if ($query_run) {
    echo 'success';
  } else {
    echo 'error';
  }
}
?>