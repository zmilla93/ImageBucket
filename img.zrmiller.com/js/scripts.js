// Popups
let loginPopup;
let signupPopup;
let uploadPopup;
let deleteImagePopup;
let screenCover;

// Error Bools
let logInError = false;
let signUpError = false
// let uploadError = false;

function init() {
    // Logout
    let logoutForm = document.getElementById("logout-form");
    let logoutElements = document.getElementsByClassName("logout");
    for (let element of logoutElements) {
        element.onclick = function () {
            logoutForm.submit();
        };
    }

    // Popups
    loginPopup = document.getElementById("login-popup");
    signupPopup = document.getElementById("signup-popup");
    uploadPopup = document.getElementById("upload-popup");
    deleteImagePopup = document.getElementById("delete-image-popup");
    screenCover = document.getElementById("screen-cover");
    let deleteImageButton = document.getElementById("delete-image-button");

    // Popup Close Buttons
    let popupCloseButtons = document.getElementsByClassName("popup-close-button");
    let showLoginElements = document.getElementsByClassName("show-login");
    let showSignupElements = document.getElementsByClassName("show-signup");
    let showUploadElements = document.getElementsByClassName("show-upload");

    // Add functionality to all login buttons
    for (let element of showLoginElements) {
        element.onclick = showLogInPopup;
    }
    // Add functionality to all signup buttons
    for (let element of showSignupElements) {
        element.onclick = showSignInPopup;
    }
    // Add functionality to all upload buttons
    for (let element of showUploadElements) {
        element.onclick = showUploadPopup;
    }
    // Add functionality to all popup close buttons
    for (let element of popupCloseButtons) {
        element.onclick = function () {
            element.closest(".popup").style.display = "none";
            screenCover.style.display = "none";
        };
    }

    // Delete image popup
    if (deleteImagePopup != undefined) {
        deleteImageButton.onclick = function () {
            screenCover.style.display = "block";
            deleteImagePopup.style.display = "block";
        }
    }
};

function showLogInPopup() {
    screenCover.style.display = "block";
    loginPopup.style.display = "block";
    signupPopup.style.display = "none";
}

function showSignInPopup() {
    screenCover.style.display = "block";
    loginPopup.style.display = "none";
    signupPopup.style.display = "block";
}

function showUploadPopup() {
    screenCover.style.display = "block";
    uploadPopup.style.display = "block";
}

function showPopupIfErrorMessage() {
    if (logInError) showLogInPopup();
    if (signUpError) showSignInPopup();
}

function setNavbarUsername(username) {
    let element = document.getElementById("navbar-username");
    let prefix = '<span class="no-select">&nbsp;|&nbsp;</span>';
    element.innerHTML = prefix + '<a href="https://img.zrmiller.com/u/' + username + '">' + username + '</a>';
}

document.addEventListener("DOMContentLoaded", init);
document.addEventListener("DOMContentLoaded", showPopupIfErrorMessage);