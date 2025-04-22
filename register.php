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

    // Validate email and password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email format.</div>";
    } else {
        // Prevent SQL injection
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='alert alert-danger'>Email is already registered.</div>";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user data into the database
            $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Registration successful! You can now <a href='login_page.php'>login</a>.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    }
}

// Close the database connection
$conn->close();
?>