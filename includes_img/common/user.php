<?php
// This file handles logging in, logging out, and signing up.

function handleLogin()
{
    global $conn;
    global $sessionErrorMessage;
    $loginErrorMessage = "Invalid username or password.";
    if (!isset($_POST['login-username']) || !isset($_POST['login-password'])) {
        $_SESSION['login-error'] = $loginErrorMessage;
        refresh();
    }
    if (!isset($_POST['login-token']) || !validateToken($_POST['login-token'])) {
        $_SESSION['login-error'] = $sessionErrorMessage;
        refresh();
    }
    // Query Databse
    $username = $_POST['login-username'];
    $stmt = $conn->prepare("SELECT id, username, password FROM `users` WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    // Login if password is correct
    if ($row != null and isset($row['id'])) {
        if (password_verify($_POST['login-password'], $row['password'])) {
            $_SESSION['logged'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user-id'] = getUsernameID($row['username']);
            // If user is on the homepage, redirect to their profile. Otherwise just refresh.
            if (strcmp($_SERVER['REQUEST_URI'], "/") == 0)
                header("Location: http://$_SERVER[HTTP_HOST]/u/$_SESSION[username]");
            else
                refresh();
            exit;
        }
    }
    // If login failed, return an error message.
    if (!$_SESSION['logged']) {
        $_SESSION['login-error'] =  $loginErrorMessage;
        refresh();
    }
}

function handleSignup()
{
    global $conn;
    global $sessionErrorMessage;
    if (!isset($_POST['signup-token']) || !validateToken($_POST['signup-token'])) {
        $_SESSION['signup-error'] = $sessionErrorMessage;
        refresh();
    }
    if (!isset($_POST['signup-username']) || !isset($_POST['signup-password']) || !isset($_POST['signup-password-confirm'])) {
        $_SESSION['signup-error'] = 'Please complete the entire form.';
        refresh();
    }
    $username = $_POST['signup-username'];
    $password = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);
    $email = $_POST['signup-email'];
    $username_length = strlen($username);
    // Validate Username
    if ($username_length < 3 || $username_length > 30) {
        $_SESSION['signup-error'] = "Username must be between 3 and 30 characters.";
        refresh();
    }
    $letterPattern = "/[A-Za-z]/";
    $firstLetter = substr($username, 0, 1);
    if (!preg_match($letterPattern, $firstLetter)) {
        $_SESSION['signup-error'] = "Username must start with a letter.";
        refresh();
    }
    $usenamePattern = "/^[A-Za-z][A-Za-z0-9_]+$/";
    if (!preg_match($usenamePattern, $username)) {
        $_SESSION['signup-error'] = "Username must only contain letters, numbers, and underscores.";
        refresh();
    }
    // Validate E-Mail if one is provided
    if (strlen($email) > 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['signup-error'] = "Invalid e-mail address.";
            refresh();
        }
    }
    // Validate Password
    if (strlen($_POST['signup-password']) < 4) {
        $_SESSION['signup-error'] = "Password must be atleast 4 characters long.";
        refresh();
    }
    // Check password and confirmation password match
    if (!strcmp($_POST['signup-password'], $_POST['signup-password-confirm']) == 0) {
        $_SESSION['signup-error'] = "Passwords do not match.";
        refresh();
    }
    // Query Database
    $stmt = $conn->prepare("SELECT username FROM `users` WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    // Check if username is unique
    if (isset($row['username'])) {
        $_SESSION['signup-error'] = "The username \"" . $username . "\" is already in use.";
        refresh();
    }
    // Signup
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$username, $password, $email])) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user-id'] = getUsernameID($username);
        header("Location: http://$_SERVER[HTTP_HOST]/u/$username");
        exit();
    } else {
        $_SESSION['signup-error'] = "Error while connecting to the host, please try again later.";
        refresh();
    }
}

function handleLogout()
{
    $_SESSION['logged'] = false;
    $_SESSION['username'] = null;
    $_SESSION['user-id'] = -1;
    refresh();
}

if (isset($_POST['signup-submit'])) handleSignup();
if (isset($_POST['login-submit'])) handleLogin();
if (isset($_POST['logout-submit'])) handleLogout();
