<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarydb";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch all books
$sql = "SELECT title, author, username, issue_date FROM books";
$result = $conn->query($sql);

// Check if there are any books in the database
if ($result->num_rows > 0) {
    $books = [];
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    $books = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All issued Books </title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>
        /* * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
} */

body {
    font-family: 'Arial', sans-serif;
    background: #1e1e1e;
    color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
}

.container {
    max-width: 1200px;
    width: 100%;
    /* padding: 30px; */
}

h1 {
    font-size: 3em;
    margin-bottom: 40px;
    color: #00ff7f;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 700;
    animation: neon 1.5s ease-in-out infinite alternate;
}

@keyframes neon {
    0% {
        text-shadow: 0 0 5px #00ff7f, 0 0 10px #00ff7f, 0 0 15px #00ff7f, 0 0 20px #00ff7f;
    }
    100% {
        text-shadow: 0 0 10px #00ff7f, 0 0 20px #00ff7f, 0 0 30px #00ff7f, 0 0 40px #00ff7f;
    }
}

.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.book-card {
    background-color: #2c2f3a;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease-in-out;
}

.book-card:hover {
    transform: scale(1.05);
}

.book-card h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #ff6347;
    text-transform: capitalize;
}

.book-card p {
    font-size: 1em;
    color: #d3d3d3;
    margin-bottom: 5px;
}

.book-card p strong {
    font-weight: bold;
}

     </style>   



</head>
<body>
    <div class="container">
        <h1>Your issued Books</h1>
        <div class="books-grid">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <h3><?= $book['title'] ?></h3>
                        <p><strong>Author:</strong> <?= $book['author'] ?></p>
                        <p><strong>Issued To:</strong> <?= $book['username'] ?></p>
                        <p><strong>Issue Date:</strong> <?= $book['issue_date'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No books found in the database.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
