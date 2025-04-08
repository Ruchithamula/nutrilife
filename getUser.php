<?php

session_start();
header('Content-Type: application/json');

// Include your database connection file
include('db_connection.php'); // Adjust the path to where your db_connect.php file is

// Check if the user is logged in (session-based check)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Check user from the database to ensure session data is valid
    $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // If user is found in the database, respond with success
        echo json_encode(["status" => "success", "username" => $username]);
    } else {
        // If user doesn't exist in the database, session may be invalid
        echo json_encode(["status" => "error", "message" => "Invalid session data. User not found in database."]);
    }
} else {
    // User is not logged in
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
}
?>
