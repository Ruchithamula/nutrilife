<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - NutriLife</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            padding: 30px;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .nav h2 { margin: 0; }
        .nav-links a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .logout {
            background: #f44336;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .logout:hover { background: #d32f2f; }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .input-form input {
            padding: 10px;
            width: 150px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .input-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .input-form button:hover { background-color: #45a049; }
        .visualization {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
        }
        .diet-info { margin-top: 20px; font-size: 1.2rem; color: #333; }
        .meal-list {
            margin-top: 20px;
            font-size: 1rem;
            color: #444;
        }
    </style>
</head>
<body>

<div class="nav">
    <h2>Welcome, <span id="username-text"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span></h2>
    <div class="nav-links">
        <a href="index.php">Home</a>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">
    <h1>Track Your Meals</h1>
    <p>Add each meal and its nutrients. Submit when done to see the visualization.</p>

    <div class="input-form">
        <input type="text" id="meal-name" placeholder="Meal Name" />
        <input type="number" step="any" id="protein" placeholder="Protein (g)" />
        <input type="number" step="any" id="carbs" placeholder="Carbs (g)" />
        <input type="number" step="any" id="fats" placeholder="Fats (g)" />
        <br>
        <button id="add-meal">Add Meal</button>
        <button id="submit-meals">Submit All Meals</button>
    </div>

    <div class="meal-list" id="meal-list"></div>

    <div class="visualization">
        <canvas id="nutrition-chart"></canvas>
    </div>

    <div class="diet-info" id="diet-info"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mealNameInput = document.getElementById("meal-name");
    const proteinInput = document.getElementById("protein");
    const carbsInput = document.getElementById("carbs");
    const fatsInput = document.getElementById("fats");
    const addMealBtn = document.getElementById("add-meal");
    const submitMealsBtn = document.getElementById("submit-meals");
    const mealListDiv = document.getElementById("meal-list");
    const dietInfo = document.getElementById("diet-info");
    const chartCanvas = document.getElementById("nutrition-chart");

    let chart;
    let meals = [];
    let totalNutrients = { Protein: 0, Carbs: 0, Fats: 0 };

    function displayMealList() {
        if (meals.length === 0) {
            mealListDiv.innerHTML = "No meals added yet.";
        } else {
            mealListDiv.innerHTML = "<strong>Meals Added:</strong><br>" + meals.map(m => 
                `${m.name} - Protein: ${m.protein}g, Carbs: ${m.carbs}g, Fats: ${m.fats}g`
            ).join("<br>");
        }
    }

    function updateChart() {
        const labels = Object.keys(totalNutrients);
        const data = Object.values(totalNutrients);

        if (chart) {
            chart.data.datasets[0].data = data;
            chart.update();
        } else {
            chart = new Chart(chartCanvas, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#ff6347', '#ffeb3b', '#4caf50']
                    }]
                }
            });
        }
    }

    function updateDietInfo() {
        dietInfo.innerHTML = `
            <strong>Total Nutrients:</strong><br>
            Protein: ${totalNutrients.Protein.toFixed(1)}g, 
            Carbs: ${totalNutrients.Carbs.toFixed(1)}g, 
            Fats: ${totalNutrients.Fats.toFixed(1)}g
        `;
    }

    addMealBtn.addEventListener("click", function () {
        const name = mealNameInput.value.trim();
        const protein = parseFloat(proteinInput.value) || 0;
        const carbs = parseFloat(carbsInput.value) || 0;
        const fats = parseFloat(fatsInput.value) || 0;

        if (!name) {
            alert("Please enter a meal name.");
            return;
        }

        meals.push({ name, protein, carbs, fats });
        mealNameInput.value = "";
        proteinInput.value = "";
        carbsInput.value = "";
        fatsInput.value = "";

        displayMealList();
    });

    submitMealsBtn.addEventListener("click", function () {
        if (meals.length === 0) {
            alert("Please add at least one meal first.");
            return;
        }

        // Reset totals
        totalNutrients = { Protein: 0, Carbs: 0, Fats: 0 };

        meals.forEach(m => {
            totalNutrients.Protein += m.protein;
            totalNutrients.Carbs += m.carbs;
            totalNutrients.Fats += m.fats;
        });

        updateChart();
        updateDietInfo();
    });

    displayMealList();
});
</script>

</body>
</html>
