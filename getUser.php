<?php

session_start();
header('Content-Type: application/json');


include('db_connection.php'); 


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];


    $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
       
        echo json_encode(["status" => "success", "username" => $username]);
    } else {
        // If user doesn't exist in the database, session may be invalidecho json_encode(["status" => "error", "message" => "Invalid session data. User not found in database."]);
    }
} else {
    
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
}
?>
