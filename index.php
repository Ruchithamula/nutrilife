<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="index-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriLife</title>
    <link rel="stylesheet" href="indexstyle.css">
    <style>
       
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

      
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            overflow-x: hidden;
        }

        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(8, 174, 14, 0.8);
            padding: 15px 30px;
            color: white;
            font-size: 1.8rem;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            border-bottom: 2px solid rgba(76, 175, 80, 0.6);
        }

      
        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color:rgb(132, 244, 62);
        }

    
        main {
            position: relative;
            height: 70vh;
            background: url('images/nutrivideo.mp4') no-repeat center center fixed;
            background-size: cover;
            margin-top: 100px;
        }

        footer {
            background-color: green;
            color: white;
            text-align: center;
            padding: 10px 15px;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            footer {
                font-size: 0.9rem;
            }
        }

       
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <header>
        <h1>NutriLife</h1>
        <nav>
            <ul>
                <li id="login-link"><a href="login.html">Log/Sign-Up</a></li>

                <!-- Links that should be visible AFTER login -->
                <li id="set-goal-link" class="hidden"><a href="set-goal.php">Set Goal</a></li>
                <li id="recommendations-link" class="hidden"><a href="recommendations.html">Recommendations</a></li>
                <li id="dashboard-link" class="hidden"><a href="dashboard.html">Dashboard</a></li>
                <li id="chart-link" class="hidden"><a href="box.html">Chart</a></li>
                <li id="username-display" class="hidden"><a href="#">Hello, <span id="username-text"></span></a></li>
                <li id="logout-link" class="hidden"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <video autoplay muted loop id="background-video">
            <source src="images/nutrivideo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </main>

    <footer>
        <h3>Welcome to NutriLife - Your Personalized Nutrition Guide</h3>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('getUser.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        console.log("User logged in:", data.username); 

                        
                        document.getElementById("login-link").classList.add("hidden");

                       
                        document.getElementById("username-text").textContent = data.username;
                        document.getElementById("username-display").classList.remove("hidden");

                        document.getElementById("set-goal-link").classList.remove("hidden");
                        document.getElementById("recommendations-link").classList.remove("hidden");
                        document.getElementById("dashboard-link").classList.remove("hidden");
                        document.getElementById("chart-link").classList.remove("hidden");
                        document.getElementById("logout-link").classList.remove("hidden");
                    } else {
                        console.log("User not logged in"); 
                    }
                })
                .catch(error => console.error("Error fetching user data:", error));
        });
    </script>

</body>
</html>
