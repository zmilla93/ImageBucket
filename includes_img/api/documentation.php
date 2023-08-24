<?php

$fileNames = [
    "users",
    "users_username",
    "users_username_images",
    "images",
    "images_uuid",
];

foreach ($fileNames as $fileName) {
    $doc = Doc::fromJsonFile($fileName);
    $doc->output();
}