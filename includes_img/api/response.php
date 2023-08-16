<?php

define("RESPONSE_CODE_VALID", 200);
define("RESPONSE_CODE_NO_CONTENT", 204);
define("RESPONSE_CODE_NOT_FOUND", 404);

function respond($data, $responseCode = RESPONSE_CODE_VALID)
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($responseCode);
    echo $json;
    exit();
}

function respondInvalid($error = "No data found matching parameters.")
{
    respond(new ErrorResponse($error));
}

function respondError($error = "Invalid API endpoint.")
{
    respond(new ErrorResponse($error), RESPONSE_CODE_NOT_FOUND);
}

class ErrorResponse
{
    public $error;
    function __construct($error)
    {
        $this->error = $error;
    }
}
