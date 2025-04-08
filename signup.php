<?php
// Database connection settings
$host = 'localhost';
$username = 'root';  // Your MySQL username
$password = 'ruchitha';      // Your MySQL password
$dbname = 'nutrilife'; // Your database name

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Handle form submission for user registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Get the password from form input

    // Validate input lengths
    if (strlen($username) > 30) { 
        echo "Error: Username is too long!";
        exit();
    }
    if (strlen($password) > 72) { // Max length for bcrypt hashed passwords
        echo "Error: Password is too long!";
        exit();
    }

    // Insert into users table with plain text password
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the query and check for success
    if ($stmt->execute([$username, $password])) {
        echo "User registered successfully!";
        // Optionally, redirect to login page after successful registration
        header("Location: login.html"); // Redirect to login page
        exit();
    } else {
        echo "Error: Could not register user.";
    }
}
?>
