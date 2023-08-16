<?php

function respond($data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    header("Content-Type: application/json; charset=UTF-8");
    echo $json;
    exit();
}

function respondError($error = "Invalid API Endpoint")
{
    respond(new ErrorResponse($error));
}

class ErrorResponse
{
    public $error;
    function __construct($error)
    {
        $this->error = $error;
    }
}
