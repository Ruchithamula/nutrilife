document.addEventListener("DOMContentLoaded", function () {
    // Fetch user details from PHP script
    fetch('getUser.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                // Get the HTML element where the username will be displayed
                let usernameDisplay = document.getElementById("username-display");
                let usernameText = document.getElementById("username-text");

                // Insert the username into the span element
                usernameText.textContent = data.username;

                // Make the username display visible
                usernameDisplay.classList.remove("hidden");
            } else {
                // If not logged in, you can handle it here (e.g., hide or show login)
                console.log("User not logged in");
            }
        })
        .catch(error => console.error("Error fetching user:", error));

    // Add event listener to the form
    const goalForm = document.getElementById("goalForm");
    goalForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form values
        const age = parseInt(document.getElementById("age").value);
        const weight = parseFloat(document.getElementById("weight").value);
        const preference = document.getElementById("preference").value;
        const goal = document.getElementById("goal").value;

        // Calculate nutrition requirements
        const nutrition = calculateNutrition(age, weight, preference, goal);

        // Store the selected data (this could be sent to a backend or stored in session storage)
        sessionStorage.setItem("age", age);
        sessionStorage.setItem("weight", weight);
        sessionStorage.setItem("preference", preference);
        sessionStorage.setItem("goal", goal);
        sessionStorage.setItem("nutrition", JSON.stringify(nutrition));

        // Redirect to the recommendations page
        window.location.href = "recommendations.html";
    });
});

function calculateNutrition(age, weight, preference, goal) {
    
    let baseProtein = weight * 0.8; 
    let baseCarbs = weight * 3;
    let baseFats = weight * 0.3; 
    
    if (age > 50) {
        baseProtein *= 1.2; 
     }

    if (goal === "weight-loss") {
        baseCarbs *= 0.8; 
        baseFats *= 0.8; 
    } else if (goal === "muscle-gain") {
        baseProtein *= 1.5; 
        baseCarbs *= 1.2;
    }

    
    if (preference === "veg") {
        baseProtein *= 0.9; 
    } else if (preference === "non-veg") {
        baseProtein *= 1.1; 
    }

    return {
        protein: baseProtein.toFixed(2),
        carbs: baseCarbs.toFixed(2),
        fats: baseFats.toFixed(2)
    };
}
