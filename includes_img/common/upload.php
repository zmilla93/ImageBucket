<?php

// Ensures that a folder exist to hold data for a user.
// Returns false if unable to create one.
function validateFolder($userFolder)
{
    $validFolder = file_exists($userFolder);
    if (!$validFolder) $validFolder = mkdir($userFolder, 0755, true);
    if (!$validFolder) return false;
    return true;
}

// Uploads an image to the server
function handleImageUpload()
{
    global $conn;
    global $thumbnailMarker;
    if (
        !$_SESSION['logged'] || !isset($_FILES['upload-file'])
        || !isset($_POST['upload-token']) || !validateToken($_POST['upload-token'])
    ) {
        $_SESSION['upload-error'] = "Failed to validate session, please try again.";
        refresh();
    }
    $error = false; // Indicates an early error during setup
    $success = false; // Indicates if the file was successfully moved to the server
    $userFolder = "../user_data/" . $_SESSION['username'];
    if (!validateFolder($userFolder)) $error = true;
    $uuid = generateImageUUID();
    $extension = "";
    $thumbnail = false;
    $animated = false;
    $file = $_FILES['upload-file'];
    // Verify an image was actually uploaded, and that it is under the size limit.
    // These checks are also done client side, so they should only trigger if users are explicitly trying to break things.
    if (empty($file['name'])) $error = true;
    if (empty($file['tmp_name'])) $error = true;
    if ($file['size'] > 1000000 * 4) {
        $_SESSION['upload-error'] = "Image is too large! Max size 4MB.";
        $error = true;
    }
    if ($error) refresh();
    // Fetch nessecary metadata
    $pathInfo = pathinfo($file['name']);
    $extension = strtolower($pathInfo['extension']);
    if ($extension == 'jpeg') $extension = 'jpg';
    $imageSize = getimagesize($file['tmp_name']);
    $destination = $userFolder . "/" . $uuid . "." . $extension;
    $thumbnailDestination = $userFolder . "/" . $uuid . $thumbnailMarker . "." . $extension;
    $mime = strtolower(mime_content_type($file['tmp_name']));
    $animated = $mime == "image/gif" && isGifAnimated($file['tmp_name']);
    // Move the file to the server
    $success = move_uploaded_file($file['tmp_name'], $destination);
    // Create thumbnail
    if ($success && is_array($imageSize)) $thumbnail = createThumbnail($destination, $thumbnailDestination, $imageSize[0], $imageSize[1], $mime);
    // Add file to database
    if ($success) {
        $sql = "INSERT INTO images (uuid, mime, extension, author, thumbnail, animated) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uuid, $mime, $extension, $_SESSION['user-id'], $thumbnail, $animated]);
    }
    // Reload the user's profile page
    header("Location: http://$_SERVER[HTTP_HOST]/u/$_SESSION[username]");
    exit;
}

// Creates a thumbnail for the given image. Returns a bool for success status
// Currently supports jpg, png, gif, and webp
function createThumbnail($originalDestination, $thumbnailDestination, $width, $height, $mime)
{
    $thumbnailWidth = 300;
    $thumbnailHeight = 200;
    $finalWidth = $width;
    $finalHeight = $height;
    // If the image needs to be rotated 90 or 270 degrees, swap width and height
    if (imageNeedsRotation($originalDestination)) {
        $temp = $finalWidth;
        $finalWidth = $finalHeight;
        $finalHeight = $temp;
    }
    // Calulate the target width and height for the thumbnail
    if ($width <= $thumbnailWidth && $height <= $thumbnailHeight)  return false;
    $widthFactor = $finalWidth / $thumbnailWidth;
    $heightFactor = $finalHeight / $thumbnailHeight;
    $factor = $widthFactor > $heightFactor ? $widthFactor : $heightFactor;
    $targetWidth = round($width / $factor);
    $targetHeight = round($height / $factor);
    $originalImage = null;
    // Create a gdimage
    switch ($mime) {
        case 'image/gif':
            $originalImage = imagecreatefromgif($originalDestination);
            break;
        case 'image/jpg':
        case 'image/jpeg':
            $originalImage = imagecreatefromjpeg($originalDestination);
            break;
        case 'image/png':
            $originalImage = imagecreatefrompng($originalDestination);
            break;
        case 'image/webp':
            $originalImage = imagecreatefromwebp($originalDestination);
            break;
    }
    // Return early if a gdimage couldn't be created
    if ($originalImage == null) return false;
    // Create the actual thumbnail via resampling, rotating if nessecary
    $thumbnailImage = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($thumbnailImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
    handleImageRotation($thumbnailImage, $originalDestination);
    // Save the thumbnail image to disk
    switch ($mime) {
        case 'image/gif':
            imagegif($thumbnailImage, $thumbnailDestination);
            break;
        case 'image/jpg':
        case 'image/jpeg':
            imagejpeg($thumbnailImage, $thumbnailDestination);
            break;
        case 'image/png':
            imagepng($thumbnailImage, $thumbnailDestination);
            break;
        case 'image/webp':
            imagewebp($thumbnailImage, $thumbnailDestination);
            break;
    }
    return true;
}

// Rotates the image if needed based on EXIF data
function handleImageRotation(&$image, $file)
{
    $exif = @exif_read_data($file);
    if (empty($exif['Orientation'])) return;
    switch ($exif['Orientation']) {
        case 3:
            $image = imagerotate($image, 180, 0);
            break;
        case 6:
            $image = imagerotate($image, -90, 0);
            break;
        case 8:
            $image = imagerotate($image, 90, 0);
            break;
    }
}

// Returns a bool indicating if the image will need to be rotated during thumbnail creation or not.
function imageNeedsRotation($file)
{
    $exif = @exif_read_data($file);
    if (empty($exif['Orientation'])) return false;
    return $exif['Orientation'] == 6 || $exif['Orientation'] == 8;
}

// Check if a gif contains more than one frame.
// Code from https://stackoverflow.com/questions/280658/can-i-detect-animated-gifs-using-php-and-gd
function isGifAnimated($path)
{
    if (!($file = @fopen($path, 'rb')))
        return false;
    $count = 0;
    // An animated gif contains multiple "frames", with each frame having a
    // header made up of:
    // * a static 4-byte sequence (\x00\x21\xF9F\x04)
    // * 4 variable bytes
    // * a static 2-byte sequence (\x00\x2C)

    // We read through the file until we reach the end of the file, or we've found
    // at least 2 frame headers
    while (!feof($file) && $count < 2) {
        $chunk = fread($file, 1024 * 100); //read 100kb at a time
        $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk, $matches);
    }
    fclose($file);
    return $count > 1;
}

function handleDeleteImage()
{
    global $conn;
    global $thumbnailMarker;
    // Validate that current user is the owner of the image being deleted
    $sql = "SELECT username, uuid, extension FROM images
        INNER JOIN users ON users.id = images.author
        WHERE users.id = ? AND images.uuid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['user-id'], $_POST['image-uuid']]);
    $row = $stmt->fetch();
    if (isset($row['username'])) {
        // Delete image files
        $userFolder = "../user_data/" . $_SESSION['username'];
        $imagePath = $userFolder . "/" . $row['uuid'] . "." . $row['extension'];
        $thumbnailPath = $userFolder . "/" . $row['uuid'] . $thumbnailMarker . "." . $row['extension'];
        if (file_exists($imagePath)) unlink($imagePath);
        if (file_exists($thumbnailPath)) unlink($thumbnailPath);
        // Delete data from database
        $sql = "DELETE FROM images WHERE uuid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_POST['image-uuid']]);
    }
    header("Location: http://$_SERVER[HTTP_HOST]/u/$_SESSION[username]");
    exit();
}

if (isset($_POST['upload-submit'])) handleImageUpload();
if (isset($_POST['delete-image'])) handleDeleteImage();
