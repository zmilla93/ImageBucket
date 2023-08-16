<?php

/**
 * This file handles parsing all incoming API requests based on the request URI.
 */

set_include_path("/home/zmilla/includes_img");
include_once "common/db_connection.php";
include_once "api/users.php";
include_once "api/response.php";

// Parse the URI, splitting it into a string of arrays.
$params = explode("/", $_SERVER['REQUEST_URI']);
if (count($params) < 3 || strcasecmp($params[1], "api") != 0)
    die("Something went wrong while connecting to the API.");
if (empty($params[2])) {
    // FIXME : Redirect to documentation once that is made?
    // header("Location: https://$_SERVER[HTTP_HOST]", true, 302);
    // exit();
}
$MIN_PARAM_COUNT = 3;
$baseRequest = $params[2];
$params = array_splice($params, 3);
while (count($params) < $MIN_PARAM_COUNT) array_push($params, null);

// Call a function based on the first parameter
switch (strtolower($baseRequest)) {
    case "users":
        handleUsersRequest($params);
        break;
    default:
        respondError();
        break;
}
