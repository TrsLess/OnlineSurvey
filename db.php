<?php
$host = "localhost"; // or 127.0.0.1
$user = "root";      // your MySQL username
$pass = "";          // your MySQL password ('' if none)
$db   = "user_auth"; // the name of your database

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
