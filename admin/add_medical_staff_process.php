<?php

include '../connect.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$cpass = $_POST['cpass'];
$specialization = $_POST['specialization'];
$status = $_POST['status'];

$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

echo "<h2>Trying to add a new user "  .  $email ."  pw="  . $pass . " and " . $cpass . "</h2>";
if ($pass != $cpass){
  echo '<div class="alert alert-danger">Passwords do not match!</div>';
  exit;
  }

preg_match('/[0-9]+/', $pass, $matches);
if (sizeof($matches) == 0) {
  echo '<div class="alert alert-danger">Password must contain at least one number.</div>';
    exit;
}

preg_match('/[!@#$%^&*()]+/', $pass, $matches);
if(sizeof($matches ) == 0) {
  echo '<div class="alert alert-danger">Password must contain at least one special character.</div>';
  exit;
}

if(strlen($pass) <= 8) {
  echo "The Password must be atleast 8 characters in length<br>";
  exit;
}

// check if user is already registered

$sql = "SELECT * FROM medical_staff where email = '$email'";

$result = $mysqli->query($sql) or die (mysqli_error($mysqli));

if ($result->num_rows > 0) {
  // User is Registered
  echo '<div class="alert alert-danger">The Email address ' . $email . ' already exists! Please use another email address.</div>';
  exit;
}

// insert a new user

$stmt = $mysqli->prepare("INSERT INTO medical_staff (user_id, first_name, last_name, email, pass, specialization) VALUES (null, ?, ?, ?, ?, ?)");

$stmt->bind_param('sssss', $first_name, $last_name, $email, $hashed_password, $specialization);
$result = $stmt->execute();

if ($result) {
echo "Registration success!";
header("Location: index.php");
}
else{
  echo "Something went wrong, not registered.";
  header("Location: register.php");
}
 
echo "<a href= 'index.php'> Return to main</a>";
?>