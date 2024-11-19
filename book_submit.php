<?php
// Database configuration
$servername = "localhost";  // Replace with your database server name
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "librarydb";      // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $username = $_POST['username'];

    // Prepare and execute SQL statement to insert data into books table
    $stmt = $conn->prepare("INSERT INTO books (title, author, username) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $author, $username);

    // Execute and check if the data was inserted
    if ($stmt->execute()) {
        // Redirect to confirmIssue.html on successful insertion
        header("Location: confirmIssue.html");
        exit(); // Ensure script stops after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
