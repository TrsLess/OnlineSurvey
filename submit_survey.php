<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "remote_work_survey";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$q1 = $_POST['q1'] ?? null;
$q2 = $_POST['q2'] ?? null;
$q3 = $_POST['q3'] ?? null;
$q4 = $_POST['q4'] ?? null;
$q5 = $_POST['q5'] ?? null;
$q6 = $_POST['q6'] ?? null;
$q7 = $_POST['q7'] ?? null;
$q8 = $_POST['q8'] ?? null;
$q9 = $_POST['q9'] ?? null;
$q10 = $_POST['q10'] ?? null;

// Prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO survey_responses (q1, q2, q3, q4, q5, q6, q7, q8, q9, q10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10);

if ($stmt->execute()) {
    echo "Thank you for completing the survey!";
    header("Location: rating.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
