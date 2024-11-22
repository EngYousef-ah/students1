let form = document.getElementById('form');

let check = document.querySelector(".check");

let username = document.getElementById('username');
let usernameEr = document.querySelector(".username-er");

let email = document.getElementById('email');
let emailEr = document.querySelector(".email-er");

let password = document.getElementById('password');
let passwordEr = document.querySelector(".password-er");

let confirmPassword = document.getElementById('confirmpassword');
let confirmPasswordEr = document.querySelector(".confirmpassword-er");


let validEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

let checkName = false;
let checkEmail = false;
let checkPassword = false;
let checkConfirmPassword = false;

username.onblur = function () {
    if (username.value == "") {
        usernameEr.style.display = "block";
        usernameEr.innerHTML = "Username can't be empty";
        username.style.borderColor = "red";
    } else if (username.value.length < 5) {
        usernameEr.style.display = "block";
        usernameEr.innerHTML = "The username must be at least 5 characters";
        username.style.borderColor = "red";
    }
    else {
        usernameEr.style.display = "none";
        username.style.borderColor = "green";
        checkName = true;
    }
}


email.onblur = function () {
    if (email.value == "") {
        emailEr.style.display = "block";
        emailEr.innerHTML = "email can't be empty";
        email.style.borderColor = "red";
    } else if (!(email.value.match(validEmail))) {
        emailEr.style.display = "block";
        emailEr.innerHTML = "Please enter valid email";
        email.style.borderColor = "red";
    }
    else {
        emailEr.style.display = "none";
        email.style.borderColor = "green";
        checkEmail = true;


    }
}


password.onblur = function () {
    if (password.value == "") {
        passwordEr.style.display = "block";
        passwordEr.innerHTML = "passwod can't be empty";
        password.style.borderColor = "red";
    } else if (password.value.length < 5) {
        passwordEr.style.display = "block";
        passwordEr.innerHTML = "The password must be at least 5 characters";
        password.style.borderColor = "red";
    }
    else if (password.value.length > 14) {
        passwordEr.style.display = "block";
        passwordEr.innerHTML = "The password must be at most 14 characters";
        password.style.borderColor = "red";
    }
    else {
        passwordEr.style.display = "none";
        password.style.borderColor = "green";
        checkPassword = true;
    }
}



confirmPassword.onblur = function () {
    if (confirmPassword.value == "") {
        confirmPasswordEr.style.display = "block";
        confirmPasswordEr.innerHTML = "Confirm passwod can't be empty";
        confirmPassword.style.borderColor = "red";
    } else if (password.value !== confirmPassword.value) {
        confirmPasswordEr.style.display = "block";
        confirmPasswordEr.innerHTML = "Password not match";
        confirmPassword.style.borderColor = "red";
    }
    else {
        confirmPasswordEr.style.display = "none";
        confirmPassword.style.borderColor = "green";
        checkConfirmPassword = true;
    }
}
form.onsubmit = function (event) {
    if (!(checkName && checkEmail && checkPassword && checkConfirmPassword)) {
        event.preventDefault()
        check.style.display = "block";
    }
}
