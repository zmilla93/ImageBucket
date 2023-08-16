<?php
include_once "classes/QueryResult.php";

function doesUserExist($username)
{
    global $conn;
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    return $stmt->rowCount() > 0;
}

function getUsernameID($username)
{
    global $conn;
    $sql = 'SELECT id FROM users WHERE username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if (empty($row['id'])) return -1;
    $id = $row['id'];
    return $id;
}

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
