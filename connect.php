<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "public_html";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>