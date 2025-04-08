document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        console.log("Server Response:", data); // Debugging
        if (data.success) {
            window.location.href = data.redirect; // Redirect to set-goal.php
        } else {
            document.getElementById("loginMessage").textContent = data.message;
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        document.getElementById("loginMessage").textContent = "An error occurred. Please try again.";
    });
});
