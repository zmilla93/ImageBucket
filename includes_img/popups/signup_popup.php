<div id="signup-popup" class="popup">
    <svg class="popup-close-button icon">
        <polygon points="11.649 9.882 18.262 3.267 16.495 1.5 9.881 8.114 3.267 1.5 1.5 3.267 8.114 9.883 1.5 16.497 3.267 18.264 9.881 11.65 16.495 18.264 18.262 16.497"></polygon>
    </svg>
    <div class="popup-wrapper">
        <form id="signup-form" method="post">
            <label>Username</label>
            <input type="text" id="signup-username" name="signup-username" autocomplete="username">
            <label>E-Mail (Optional)</label>
            <input type="text" id="signup-email" name="signup-email" autocomplete="email">
            <label>Password</label>
            <input type="password" id="signup-password" name="signup-password" autocomplete="new-password">
            <label>Confirm Password</label>
            <input type="password" id="signup-password-confirm" name="signup-password-confirm" autocomplete="new-password">
            <input type="hidden" name="signup-token" value="<?php echo getToken() ?>">
            <div id="signup-error" class="error-message">
                <?php if (isset($_SESSION['signup-error'])) {
                    echo $_SESSION['signup-error'];
                    echo '<script>signUpError = true</script>';
                    $_SESSION['signup-error'] = null;
                } ?>
            </div>
            <input type="hidden" name="signup-submit">
            <button id="signup-submit-button" type="submit" name="signup-submit-button">Sign Up</button>
            <div class="center-text flex-wrap">Already have an account?&nbsp;<span class="link show-login">Log in!</span></div>
        </form>
    </div>
</div>