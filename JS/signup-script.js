document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const dataForm = new FormData(this);

    fetch('/PHP/signup_functions.php', {
        method: 'POST',
        body: dataForm
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }

        const contentType = response.headers.get("Content-Type");
        if (contentType) {
            return response.json();
        } else {
            throw new Error("Invalid JSON response from server");
        }
    })
    .then(data => {
        console.log("Response data:", data);
        if (data.success) {
            console.log("account created");
            alert("Account created!");
            document.getElementById('login-form').style.display = "none";
        } else {
            console.log("Account creation failed:", data.message);
            alert(data.message);
            //document.getElementById('login-form').style.display = "none";
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});