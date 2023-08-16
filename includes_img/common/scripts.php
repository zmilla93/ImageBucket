<?php

// Thumbnail marker can be added after an image UUID to request the thumbnail version if available.
$thumbnailMarker = "_thumbnail";

// Error messages
$sessionErrorMessage = "Failed to validate session, please try again.";

// Reloads the current page in a way that prevents form resubmission
function refresh()
{
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit();
}

// Generates a random string of upper and lower case letters
function getCustomUUID($length)
{
    $uuid = '';
    $i = 0;
    for ($i = 0; $i < $length; $i++) {
        $capital = random_int(0, 1);
        $bin = null;
        if ($capital === 0) {
            $bin = random_int(97, 122);
            $uuid .= chr($bin);
        } else {
            $bin =  random_int(65, 90);
            $uuid .= chr($bin);
        }
    }
    return $uuid;
}

// This is a very crude way to generate a unique UUID, but works just fine for a proof of concept.
// A proper algorithm would take far more work than nessecary for the scope of this project.
function generateImageUUID()
{
    while (true) {
        global $conn;
        $uuid = getCustomUUID(8);
        $sql = "SELECT id FROM images WHERE uuid = ? COLLATE `utf8mb4_bin`";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uuid]);
        $row = $stmt->fetch();
        if (!isset($row['id'])) {
            return $uuid;
        }
    }
}

// Generates a unique token to prevent duplicate form submissions.
function getToken()
{
    $maxTokens = 1000;
    $token = sha1(mt_rand());
    if (!isset($_SESSION['tokens'])) {
        $_SESSION['tokens'] = array($token => 1);
    } else {
        $_SESSION['tokens'][$token] = 1;
    }
    while (count($_SESSION['tokens']) > $maxTokens) {
        array_shift($_SESSION['tokens']);
    }
    return $token;
}

// Validates a submitted form token
function validateToken($token)
{
    if (!empty($_SESSION['tokens'][$token])) {
        unset($_SESSION['tokens'][$token]);
        return true;
    }
    return false;
}
