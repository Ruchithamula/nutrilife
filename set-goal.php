<?php
session_start(); // Start the session

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login if session is not set
    exit();
}
echo "Welcome, " . $_SESSION['username']; // Display logged-in username
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Goals - NutriLife</title>
    <script src="Goalscript.js"></script>

    <style> 
        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling with the new background image */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://static.vecteezy.com/system/resources/previews/046/112/876/non_2x/vegetarian-border-of-fresh-wet-vegetables-and-fruits-against-a-shining-green-bokeh-background-healthy-and-vitamin-nutrition-photo.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        /* Header and Navigation styling */
        header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(76, 175, 80, 0.8); /* Green with transparency */
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            width: 100%;
            max-width: 500px; /* Match form size */
            margin-bottom: 10px;
        }

        header img {
            width: 80px; /* Reduced image size */
            height: auto;
            margin-right: 15px;
        }

        /* Remove absolute positioning from nav */
        nav {
            background-color: transparent; /* Transparent background */
            width: 100%;
            margin-top: 20px; /* Add margin to ensure it doesn't overlap the header */
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            justify-content: center;
        }

        nav ul li {
            margin: 0 12px;
        }

        nav ul li a {
            text-decoration: none;
            color: rgb(17, 16, 16);
            font-weight: bold;
            padding: 8px;
            transition: color 0.3s ease-in-out;
        }

        nav ul li a:hover {
            color: #4CAF50; /* Highlighted color on hover */
        }

        nav ul li a.active {
            color: #4CAF50; /* Highlighted color for active link */
        }

        /* Main content section */
        main {
            background: rgba(255, 255, 255, 0.9); /* Transparent white background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 999;
            animation: fadeIn 2s ease-in-out;
        }

        /* Form label and input styling */
        label {
            font-size: 1.2rem;
            margin: 10px 0 5px;
            color: #333;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease-in-out;
        }

        input:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Button styling */
        button {
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Form animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .checkbox-container {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .checkbox-container input[type="checkbox"] {
        margin-right: 1px;
    }

        /* Responsiveness for small screens */
        @media (max-width: 768px) {
            header {
                font-size: 1rem;
            }

            nav {
                top: 50px; /* Adjust for smaller header */
            }

            button {
                width: 100%;
            }
        }
        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="set-goal.html" class="active">Diet Goals</a></li>
            <li><a href="recommendations.html">Recommendations</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="box.html">Chart</a></li>
            <li id="username-display" style="display: none;">
                <a href="#">Hello <span id="username-text"></span></a>
            </li>
            <a href="logout.php" class="logout">Logout</a>
        </ul>
    </nav>

    <header>
        <h1>Set Your Nutrition Goals</h1>
    </header>

    <main>
        <form id="goalForm">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required>

            <label for="preference">Dietary Preference:</label>
            <select id="preference" name="preference">
                <option value="veg">Vegetarian</option>
                <option value="non-veg">Non-Vegetarian</option>
                <option value="Veg & Non-Veg">Veg & Non-Veg</option>
            </select>

            <label for="goal">Your Goal:</label>
            <select id="goal" name="goal">
                <option value="weight-loss">Weight Loss</option>
                <option value="muscle-gain">Muscle Gain</option>
                <option value="balanced">Balanced Nutrition</option>
            </select>
            <div class="checkbox-container">
        <input type="checkbox" id="healthConfirmation" required>
        <label for="healthConfirmation">I confirm that I have no health issues.</label>
    </div>

            <button type="submit">Submit</button>
        </form>
    </main>

   
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("Fetching user...");
        
            fetch('getUser.php')
                .then(response => response.json())
                .then(data => {
                    console.log("Response received:", data);  // Debugging
        
                    if (data.status === "success") {
                        let usernameDisplay = document.getElementById("username-display");
                        let usernameText = document.getElementById("username-text");
        
                        if (usernameText && usernameDisplay) {  // Ensure elements exist
                            usernameText.textContent = data.username;
                            usernameDisplay.style.display = "inline";  // Show the username
                            console.log("Username displayed:", data.username);
                        } else {
                            console.error("Username elements not found in DOM!");
                        }
                    } else {
                        console.log("User not logged in:", data.message);
                    }
                })
                .catch(error => console.error("Error fetching user:", error));
        });
        
        
        </script>
        
</body>
</html>
