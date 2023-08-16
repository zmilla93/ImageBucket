<?php
include "classes/QueryResult.php";
include "classes/User.php";

// User queries

function doesUserExist($username)
{
    global $conn;
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    return $stmt->rowCount() > 0;
}

// Returns user id on success, returns -1 for nonexistant users.
function getUsernameID($username)
{
    global $conn;
    $sql = 'SELECT id FROM users WHERE username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row['id'])) return -1;
    $id = $row['id'];
    return $id;
}

function fetchUserInfo($username)
{
    global $conn;
    $sql = "SELECT username, timeJoined FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
    $user = $stmt->fetch();
    return $user;
}

function fetchAllUsers()
{
    global $conn;
    $sql = "SELECT username, timeJoined FROM users ORDER BY username ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_CLASS, "User");
    return $rows;
}

// Image Queries

function fetchImagesByUsername($username)
{
    global $conn;
    $sql = "SELECT uuid, extension, animated FROM images
    INNER JOIN `users` ON `users`.`id` = `images`.`author`
    WHERE `users`.`username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    return QueryResult::multipleRows($stmt);
}
