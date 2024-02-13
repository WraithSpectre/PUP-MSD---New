<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

$email = $_POST['email'];
$pass = $_POST['pass'];

// Handle database connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("SELECT admin_id, email, pass, account_status FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);

$stmt->execute();
$stmt->store_result();

$stmt->bind_result($adminid, $email, $stored_password, $account_status);

if ($stmt->num_rows == 1 && $stmt->fetch() && password_verify($pass, $stored_password)) {
    $_SESSION['email'] = $email;
    $_SESSION['admin_id'] = $adminid;

    if ($account_status === "active") {
        header("Location: ../admin/index.php");
        exit;
    } elseif ($account_status === "inactive") {
        header("Location: index.php");
    } else {
        header("Location: index.php");
    }
    exit;
} else {
    // Redirect in case of authentication failure
    session_destroy();
    header("Location: index.php");
    exit;
}
?>