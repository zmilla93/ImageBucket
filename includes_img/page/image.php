<?php
// This page is shown when a single image is viewed
// IE https://img.zrmiller.com/i/ZLavQnTK

// Get image data from database
$sql = "SELECT username, users.id, uuid, extension, timeUploaded FROM images
INNER JOIN `users` ON `users`.`id` = `images`.`author`
WHERE `images`.`uuid` = ? COLLATE `utf8mb4_bin`";
$isThumbnailRequest = false;
if (isThumbnailRequest($_GET['image_raw'])) {
    $_GET['image_raw'] = cleanThumbnailRequest($_GET['image_raw']);
    $isThumbnailRequest = true;
}
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['image_raw']]);
$row = $stmt->fetch();

// If no image was found, print not found message and return early
if ($stmt->rowCount() == 0) { ?>
    <div class="center-wrapper not-found">
        Image not found.
    </div>
<?php
    return;
} else {
    // If an image was found, show the uploader's username in the navbar
?>
    <script>
        setNavbarUsername("<?php echo $row['username'] ?>");
    </script>
<?php
}

// Format date
$uploadTime  = new DateTimeImmutable($row['timeUploaded']);
$dateFormatted = DateTime::createFromFormat("Y-m-d H:i:s", $row['timeUploaded']);
$dateFormatted = $dateFormatted->format('n/j/y');

// Check if the current user is the image owner
$isImageOwner = $row['username'] == $_SESSION['username'] && $row['id'] == $_SESSION['user-id'];
$lastImageUUID = $row['uuid'];

?>

<!-- Image Info & Buttons -->
<div id="image-info" class="margin-top">
    Uploaded <?php echo $dateFormatted ?>
    <a href="https://img.zrmiller.com/i/<?php echo $row['uuid'] . "." . $row['extension'] ?>" class="button margin-left" target="_blank">Fullscreen</a>
    <a href="https://img.zrmiller.com/i/<?php echo $row['uuid'] . "." . $row['extension'] ?>" download="<?php echo $row['uuid'] . "." . $row['extension'] ?>" class="button margin-left">Download</a>
    <?php
    if ($isImageOwner) echo '<span id="delete-image-button" class="button delete-button  margin-left">Delete Image</span>';
    ?>
</div>

<!-- Image -->
<div id="image-wrapper">
    <img id="view-image" src="https://img.zrmiller.com/i/<?php echo $row['uuid'] . "." . $row['extension'] ?>">
</div>

<?php
// Image deletion popup
if ($isImageOwner) include "popups/delete_image_popup.php";
?>