<div id="delete-image-popup" class="popup">
    <svg class="popup-close-button icon">
        <polygon points="11.649 9.882 18.262 3.267 16.495 1.5 9.881 8.114 3.267 1.5 1.5 3.267 8.114 9.883 1.5 16.497 3.267 18.264 9.881 11.65 16.495 18.264 18.262 16.497"></polygon>
    </svg>
    <div class="popup-wrapper">
        <div>
            Are you sure you want to delete this image?<br>
            This action cannot be undone.
        </div>
        <form method="post">
            <input type="hidden" name="image-uuid" value="<?php
                                                            if (isset($isImageOwner) && $isImageOwner && isset($lastImageUUID))
                                                                echo $lastImageUUID;
                                                            ?>">
            <button type="submit" name="delete-image" class="delete-button margin-top">Delete Image</button>
        </form>
    </div>
</div>