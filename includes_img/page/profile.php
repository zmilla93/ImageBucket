<?php

// This page is shown when you view a user's profile page.
// IE https://img.zrmiller.com/u/asdf

$username = filter_input(INPUT_GET, "profile");
$userExists = doesUserExist($username);
$result = null;

if ($userExists) {
    $result = fetchImagesByUsername($username);
?>
    <script>
        setNavbarUsername("<?php echo $username ?>");
    </script>
    <?php
    if ($result->rowCount == 0) { 
        // Display a message if the user exists, but has no images uploaded
        ?>
        <div class="center-wrapper not-found">
            <?php
            if ($username == $_SESSION['username']) { ?>
                <div>You have not uploaded any images yet.</div>
                <div>Click the upload button in the top right to get started!</div>
            <?php } else { ?>
                <div>This user has not uploaded any images.</div>
            <?php } ?>
        </div>
        <?php
    } else {
        echo '<div id="gallery-wrapper">';
        // Generate HTML for all images for the given profile
        foreach ($result->data as $row) { ?>
            <div class="gallery-image-wrapper">
                <a href="/i/<?php echo $row['uuid'] ?>" class="image-in-gallery center-text">
                    <img src="https://img.zrmiller.com/i/<?php echo $row['uuid'] . $thumbnailMarker . "." . $row['extension'] ?>" class="gallery-image center-text image-link" loading="lazy">
                </a>
                <?php
                if ($row['animated']) { ?>
                    <div class="image-overlay">GIF</div>
                <?php } ?>
            </div>
    <?php
        }
        echo '</div>';
    }
} else { 
    // Display a message if the user doesn't exist
    ?>
    <div class="center-wrapper not-found">
        No one by this username was found.
    </div>
<?php
}
