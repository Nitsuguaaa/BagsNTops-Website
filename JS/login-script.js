document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const dataForm = new FormData(this);

    fetch('/PHP/login_functions.php', {
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
            if(data.message === "admin.login") {
                window.open("/admin-receipt.php");
            } else {
                console.log("Login success! message: " + data.message);
                alert("Successfuly Logged In!");
                document.getElementById('login-form').style.display = "none";    
                location.reload();
            }

        } else {
            console.log("Login failed:", data.message);
            alert("Incorrect email/password");
            document.getElementById('login-form').style.display = "none";
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});