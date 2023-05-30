<div id="upload-popup" class="popup">
    <svg class="popup-close-button icon">
        <polygon points="11.649 9.882 18.262 3.267 16.495 1.5 9.881 8.114 3.267 1.5 1.5 3.267 8.114 9.883 1.5 16.497 3.267 18.264 9.881 11.65 16.495 18.264 18.262 16.497"></polygon>
    </svg>
    <div class="popup-wrapper">
        <div id="upload-drop-area" class="center-text">Drop Image Here</div>
        <div id="or-box" class="center-text">OR</div>
        <form id="image-upload-form" method="post" enctype="multipart/form-data">
            <label for="fileInput" class="popup-button center-text margin-top">Browse for Image</label>
            <input id="fileInput" name="upload-file" type="file" accept="image/*" style="display:none">
            <div id="upload-preview-image-wrapper">
                <img src="" id="upload-preview-image"></img>
            </div>
            <input type="hidden" name="upload-token" value="<?php echo getToken() ?>">
            <input type="hidden" name="upload-submit">
            <button id="upload-submit-button" type="submit" name="upload-submit-button" class="margin-top">Submit</button>
            <label id="image-upload-error" class="error-message">
                <?php if (isset($_SESSION['upload-error'])) {
                    echo $_SESSION['upload-error'];
                    echo '<script>uploadError = true</script>';
                    $_SESSION['upload-error'] = null;
                } ?>
            </label>
        </form>
    </div>
</div>