<?php

/**
 * Handles the following endpoints:
 * /users - Returns a list of all users
 * /users/{username} - Returns username, url, and joindate
 * /users/{username}/images - Returns all images uploaded by the user
 */

include "api/response.php";
include "common/queries.php";

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
        return new User($row['username'], $row['timeJoined']);
    }

    static function fetchFromUsername($username)
    {
        $result = getUserInfo($username);
        if ($result->success) return User::fromRow($result->data);
        respondInvalid("No one by the username '" . $username . "' was found.");
    }

    static function fetchAllUsers()
    {
        $result = getAllUsers();
        $users = [];
        foreach ($result->data as $row) {
            $user = User::fromRow($row);
            array_push($users, $user);
        }
        return $users;
    }
}