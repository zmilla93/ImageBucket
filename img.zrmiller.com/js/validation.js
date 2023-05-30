// Login References
let loginButton;
let loginUsernameInput;
let loginErrorElement;

// Signup References
let signupButton;
let signupUsernameInput;
let signupPasswordInput;
let signupPasswordConfirmInput;
let signupErrorElement;

// Regex
const usernamePattern = /^[A-Za-z][A-Za-z0-9_]+$/;

function init() {
    // Login References
    loginButton = document.getElementById("login-submit-button");
    loginUsernameInput = document.getElementById("login-username");
    loginErrorElement = document.getElementById("login-error");

    // Signup References
    signupButton = document.getElementById("signup-submit-button");
    signupUsernameInput = document.getElementById("signup-username");
    signupPasswordInput = document.getElementById("signup-password");
    signupPasswordConfirmInput = document.getElementById("signup-password-confirm");
    signupErrorElement = document.getElementById("signup-error");

    // Login Validation
    let loginForm = document.getElementById("login-form");
    if (loginForm != null) loginForm.onsubmit = validateLogin;

    // Signup Validation
    let signupForm = document.getElementById("signup-form");
    if (signupForm != undefined) signupForm.onsubmit = validateSignup;
}

function validateLogin() {
    let username = loginUsernameInput.value;
    if (!usernamePattern.test(username)) {
        loginError("Invalid username or password.");
        return false;
    }
    loginButton.disabled = true;
    return true;
}

function validateSignup() {
    let username = signupUsernameInput.value;
    let password = signupPasswordInput.value;
    let passwordConfirm = signupPasswordConfirmInput.value;

    // Username validation
    if (username.length < 3 || username.length > 30) {
        signupError("Username must be between 3 and 30 characters.");
        return false;
    }
    if (username.length < 3 || username.length > 30) {
        signupError("Username must be between 3 and 30 characters.");
        return false;
    }
    const letterPattern = /[A-Za-z]/;
    const firstLetter = username.charAt(0);
    if (!letterPattern.test(firstLetter)) {
        signupError("Username must start with a letter.");
        return false;
    }
    if (!usernamePattern.test(username)) {
        signupError("Username must only contain letters, numbers, and underscores.");
        return false;
    }

    // Password validation
    if (!(password === passwordConfirm)) {
        signupError("Passwords do not match.");
        return false;
    }
    if (password.length < 4) {
        signupError("Password must be at least 4 characters long.");
        return false;
    }
    signupButton.disabled = true;
    return true;
}

function signupError(error) {
    signupErrorElement.innerHTML = error;
}

function loginError(error) {
    loginErrorElement.innerHTML = error;
}

document.addEventListener("DOMContentLoaded", init);