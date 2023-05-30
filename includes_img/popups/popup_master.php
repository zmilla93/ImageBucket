<?php
include "popups/screen_cover.php";
if ($_SESSION['logged']) {
    include "popups/upload_popup.php";
    // Delete image popup is handled in image.php
} else {
    include "popups/login_popup.php";
    include "popups/signup_popup.php";
}
