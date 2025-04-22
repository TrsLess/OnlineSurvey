<?php
require 'db.php';

// Start the session
session_start();

// Database connection
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "user_auth";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Query the database for the user with the given email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Check if the entered password matches the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Start a session and save user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Redirect to a dashboard or home page
            header("Location: index.html");  // Change this to your desired page
            exit();
        } else {
            echo "<div class='alert alert-danger'>Incorrect password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No user found with this email.</div>";
    }
}

// Close the database connection
$conn->close();
?>
