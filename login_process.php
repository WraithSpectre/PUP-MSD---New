<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

$email = $_POST['email'];
$pass = $_POST['pass'];

$stmt = $mysqli->prepare("SELECT user_id, email, pass, specialization FROM medical_staff WHERE email = ?");
$stmt->bind_param("s", $email);

$stmt->execute();
$stmt->store_result();

$stmt->bind_result($userid, $email, $stored_password, $specialization);

if ($stmt->num_rows == 1) {
    if ($stmt->fetch() && password_verify($pass, $stored_password)) {
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $userid;

        ob_end_clean();

        if ($specialization === "Doctor") {
            header("Location: ./Doctor/index.php");
            exit;
        } elseif ($specialization === "Nurse") {
            header("Location: ./md_staff/index.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
    exit;
}
?>