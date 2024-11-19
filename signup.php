<?php
// Database configuration
$servername = "localhost";  
$username = "root";      
$password = "";      
$dbname = "librarydb";               

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        header("Location: signup.html");
        exit();
    } else {
        // No hashing here
        $plain_password = $password;

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $plain_password);

        // Execute and check if the data was inserted
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
            header("Location: signup.html");
            exit();
        }

        // Close the statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
