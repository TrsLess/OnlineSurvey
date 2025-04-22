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

if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO survey_ratings (rating, created_at) VALUES (?, NOW())");
    $stmt->bind_param("i", $rating);

    if ($stmt->execute()) {
        header("Location: home_page.html?rating_success=1");
        exit();
    } else {
        echo "Error storing rating: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No rating received.";
}

$conn->close();
?>
