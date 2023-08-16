<?php

/**
 * Handles the following endpoints:
 * /images - Return a list of all images
 * /images/{uuid} - Returns metadata for a single image
 */

function handleImageRequest($params)
{
    $uuid = $params[0];
    // No images endpoints require 2 parameters, return an error.
    if ($params[1] != null) respondError();
    // Endpoint: /images/{uuid}
    if($uuid != null){
        $result = fetchImageData($uuid);
        if(!$result) respondError("Invalid image uuid.");
        else respond($result);
    }
    // Endpoint: /images
    $result = fetchAllImages();
    respond($result);
}
