<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: index.php"); // Redirect to login page
exit();
?>

<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .logout-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>You have been logged out successfully.</h2>
        <p>Click <a href="index.php">here</a> to go back to the homepage.</p>
    </div>
</body>
</html>
