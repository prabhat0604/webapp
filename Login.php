<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="form-container">
        <h1>Login to your account</h1>
        <form action="login.php" method="POST">

            <div class="form-control">
                <input type="text" id="username" name="username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-control">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn">Login</button>

            <p class="text">Don't have an account? Let's create one.<br/>
                <a href="./SignUp.html" id="signUp" class="sign-up btn">Sign Up</a>
            </p>

        </form>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>

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
session_start();
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists in database
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Directly compare entered password with stored password
        if ($password === $stored_password) {
            $_SESSION['username'] = $username;  // Store username in session
            // Redirect to welcome.html on successful login
            header("Location: welcome.html");
            exit();
        } else {
            // Redirect back to login.html if password is incorrect
            header("Location: login.php");
            exit();
        }
    } else {
        // Redirect back to login.html if username is not found
        header("Location: login.php");
        exit();
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
