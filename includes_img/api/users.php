<?php

/**
 * Handles the following endpoints:
 * /users - Returns a list of all users
 * /users/{username} - Returns username, url, and joindate
 * /users/{username}/images - Returns all images uploaded by the user
 */

include_once "api/response.php";

function handleUsersRequest($params)
{
    $username = $params[0];
    $images = $params[1];
    if ($params[2] != null) {
        respondError();
    }
    if ($images != null) {
        if (strcasecmp($images, "images") == 0) {
            respondError("Not Implemented");
        } else respondError();
    }
    if ($username != null) {
        $user = User::fetchFromUsername($username);
        respond($user);
    }
    $allUsers = User::fetchAllUsers();
    respond($allUsers);
}

class User
{
    public $username;
    public $joinDate;
    public $url;

    function __construct($username, $joinDate)
    {
        $this->username = $username;
        $this->url = "https://img.zrmiller.com/u/" . $username;
        $this->joinDate = $joinDate;
    }

    static function fromRow($row)
    {
        return new User($row['username'], $row['time_joined']);
    }

    static function fetchFromUsername($username)
    {
        global $conn;
        $sql = "SELECT username, time_joined FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        if ($stmt->rowCount() < 1) {
            respondInvalid("No one by the username '" . $username . "' was found.");
        }
        $row = $stmt->fetch();
        return User::fromRow($row);
    }

    static function fetchAllUsers()
    {
        global $conn;
        $sql = "SELECT username, time_joined FROM users ORDER BY username ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $users = [];
        foreach ($rows as $row) {
            $user = User::fromRow($row);
            array_push($users, $user);
        }
        return $users;
    }
}
