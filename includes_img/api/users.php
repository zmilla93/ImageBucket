<?php

/**
 * Handles all /users/* endpoints:
 * /users - Returns a list of all users
 * /users/{username} - Returns username, url, and joinDate
 * /users/{username}/images - Returns all images uploaded by the user
 */

function handleUsersRequest($params)
{
    $username = $params[0];
    $images = $params[1];
    // No users endpoint require 3 parameters, so return an error
    if ($params[2] != null) {
        respondError();
    }
    // Endpoint: users/{username}/images
    if ($images != null) {
        if (strcasecmp($images, "images") == 0) {
            $result = fetchUserImages($username);
            if ($result === false) respondInvalidUser($username);
            respond($result);
        } else respondError();
    }
    // Endpoint: users/{username}
    if ($username != null) {
        $user = fetchUserInfo($username);
        if (!$user) respondInvalidUser($username);
        respond($user);
    }
    // Endpoint: users
    $allUsers = fetchAllUsers();
    respond($allUsers);
}
