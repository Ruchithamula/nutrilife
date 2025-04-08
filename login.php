<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';  
$password = 'ruchitha'; 
$dbname = 'nutrilife';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $e->getMessage()]);
    exit();
}

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit();
}

// Get form data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate input length
if (strlen($username) > 30 || strlen($password) > 72) {
    echo json_encode(["success" => false, "message" => "Invalid input length"]);
    exit();
}

// Query to check if the user exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists and verify plain text password
if ($user && $user['password'] === $password) { // Plain text check
    $_SESSION['username'] = $username; // Set session
    
    echo json_encode(["success" => true, "redirect" => "set-goal.php"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid username or password"]);
}
?>
