<?php
$host = "localhost";
$user = "root"; // use your username
$pass = "";     // your MySQL password, if set
$db = "task6";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
