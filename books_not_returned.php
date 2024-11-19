<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not, redirect to login page (optional)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarydb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch books that are not returned
$sql = "SELECT title, author, username, issue_date FROM books WHERE is_returned = 0";
$result = $conn->query($sql);

// Check if there are any unreturned books
$books_not_returned = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books_not_returned[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Not Returned</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5dc;
            color: #333;
            text-align: center;
        }
        .container {
            margin: 50px auto;
            max-width: 800px;
            background-color: #e3d5ca;
            padding: 20px;
            border-radius: 8px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }
        .book-card {
            background-color: #d5bda7;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .book-card h3 {
            font-size: 1.5em;
            margin-bottom: 5px;
        }
        .book-card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Books Not Returned</h1>
        <?php if (count($books_not_returned) > 0): ?>
            <?php foreach ($books_not_returned as $book): ?>
                <div class="book-card">
                    <h3><?= $book['title'] ?></h3>
                    <p><strong>Author:</strong> <?= $book['author'] ?></p>
                    <p><strong>Issued To:</strong> <?= $book['username'] ?></p>
                    <p><strong>Issue Date:</strong> <?= $book['issue_date'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No unreturned books found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>
