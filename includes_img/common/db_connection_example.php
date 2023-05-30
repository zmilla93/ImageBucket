<?php
// This file handles connecting to the database using pdo.
// This is the first thing to run when a page is loaded.
// https://www.php.net/manual/en/book.pdo.php

// Connection info
$host = "";
$db = "";
$username = "";
$password = "";

// Connect to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    die("There was an issue while trying to connect to the host, please try again later.");
}
