<?php

$testDoc = new Doc();
$testDoc->endpoint = "/users/{username}/images";
$testDoc->description = "Returns an array of image data for the given user.";
$testDoc->addParameter("username", "String", "The username of the target.");
$testDoc->addParameter("uuid", "String", "The uuid of the image.");
$testDoc->addResponse("author", "String", "The username of the user who uploaded the image.");
$testDoc->addResponse("uuid", "String", "The uuid of the image.");
$testDoc->example = file_get_contents(stream_resolve_include_path("api/docs/test_example.json"));
