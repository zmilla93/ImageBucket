<?php

// This file runs when a user attempts to view a direct link to an image.
// IE https://img.zrmiller.com/i/stZgznvZ.gif
// This also runs once per image when viewing a profile.

// Takes a row from the image table and serves the corresponding image
function displayImage($row, $thumbnail)
{
    global $thumbnailMarker;
    if ($row != null && isset($row['uuid'])) {
        $path = null;
        if ($thumbnail && $row['thumbnail'])
            $path = $_SERVER['DOCUMENT_ROOT'] . "/../user_data/" . $row['username'] . "/" . $row['uuid'] . $thumbnailMarker . "." . $row['extension'];
        else
            $path = $_SERVER['DOCUMENT_ROOT'] . "/../user_data/" . $row['username'] . "/" . $row['uuid'] . "." . $row['extension'];
        if (file_exists($path)) {
            header("Content-Type: " . $row['mime']);
            header("Content-Length: " . filesize($path));
            readfile($path);
            exit;
        }
    }
    // If no image is found, return a placeholder image.
    $path = $_SERVER['DOCUMENT_ROOT'] . "/../includes_img/not-found.png";
    if (file_exists($path)) {
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($path));
        readfile($path);
        exit;
    }
    die("Error fetching image from host. Please try again later.");
}

function isThumbnailRequest($request)
{
    global $thumbnailMarker;
    return str_contains($request, $thumbnailMarker);
}

function cleanThumbnailRequest($request)
{
    global $thumbnailMarker;
    $request = str_replace($thumbnailMarker, "", $request);
    return $request;
}

// Fetch image row from database, then display the image
if ((isset($_GET['image_uuid']))) {
    $uuid = $_GET['image_uuid'];
    $thumbnail = isThumbnailRequest($uuid);
    if ($thumbnail) $uuid = cleanThumbnailRequest($uuid);
    $imagePattern = "/([A-Za-z]+)\.([A-Za-z]+)/";
    if (preg_match($imagePattern, $uuid, $groups)) {
        global $conn;
        $sql = "SELECT username, uuid, mime, extension, thumbnail FROM images
        INNER JOIN `users` ON `users`.`id` = `images`.`author`
        WHERE `images`.`uuid` = ? COLLATE `utf8mb4_bin`";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$groups[1]]);
        $row = $stmt->fetch();
        if ($row['extension'] == $groups[2]) displayImage($row, $thumbnail);
        else displayImage(null, false);
    }
}
