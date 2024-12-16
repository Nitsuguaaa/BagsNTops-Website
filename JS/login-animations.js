
// When the user clicks anywhere outside of the modal, close it
window.addEventListener('click', function(event) {
    const modal = document.getElementById('login-form');
    const modal2 = document.getElementById('logout-screen');
    switch(event.target) {
        case modal:
            modal.style.display = "none";
        break;
        case modal2:
            modal2.style.display = "none";
        break; 
    }
});




var x = document.getElementById("loginForm");
var y = document.getElementById("signupForm");
var z = document.getElementById("btn");

function signupAnimate() {
    x.style.left = "-750px";
    y.style.left = "50px";
    z.style.left = "130px";
}

function loginAnimate() {
    x.style.left = "50px";
    y.style.left = "850px";
    z.style.left = "0px";
}

document.getElementById('loginBtn').addEventListener('click', function(event) {

    fetch('/PHP/login_animations.php', {
        method: 'GET',
        headers: {
            "content-type": "application/json"
        }
    })
    .then(response => {
        if(response.ok) {
            return response.json();
        } else {
            throw new Error('Network Error');
        }
    })
    .then(data => {
        if(data.isLogged) {
            const loginButton = document.querySelector('#loginBtn');
            const logoutScreen = document.querySelector('#logout-screen');
            const logoutbox = document.querySelector('#logout-box');

            logoutbox.style.position = 'absolute'; // Ensure positioning
            logoutbox.style.marginLeft = `${loginButton.offsetLeft-50}px`;
            logoutbox.style.marginTop = `${loginButton.offsetTop + 55}px`;

            logoutScreen.style.display = "block";
            //document.getElementById('logout-screen').style.display = "block";
            console.log("current session: " + data.currentSession);
            
        } else {          
           document.getElementById('login-form').style.display = "block";
           console.log("current session: " + data.currentSession);
        }
    })
    .catch(error =>{
        console.log('error parsing the data <3')
    })
})

document.getElementById('logoutBtn').addEventListener('click', function(event) {

    fetch('/PHP/logout_functions.php', {
        method: 'GET',
        headers: {
            "content-type": "application/json"
        }
    })
    .then(response => {
        if(response.ok) {
            return response.json();
        } else {
            throw new Error('Network Error');
        }
    })
    .then(data => {
        document.getElementById('logout-screen').style.display = "none";
        alert('successfully logged out!');
        location.reload();
    })
    .catch(error =>{
        console.log('error parsing the data <3')
    })
})