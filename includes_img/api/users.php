<?php

/**
 * Handles the following endpoints:
 * /users - Returns a list of all users
 * /users/{username} - Returns username, url, and joindate
 * /users/{username}/images - Returns all images uploaded by the user
 */

function handleUsersRequest($params)
{
    $username = $params[0];
}

class User
{
    public $username;
    public $joinDate;
    public $url;

    function __construct($username, $joinDate)
    {
    }
}
