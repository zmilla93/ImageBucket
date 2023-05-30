    <!-- Log In Popup -->
    <div id="login-popup" class="popup">
        <svg class="popup-close-button icon">
            <polygon points="11.649 9.882 18.262 3.267 16.495 1.5 9.881 8.114 3.267 1.5 1.5 3.267 8.114 9.883 1.5 16.497 3.267 18.264 9.881 11.65 16.495 18.264 18.262 16.497"></polygon>
        </svg>
        <div class="popup-wrapper">
            <form id="login-form" method="post">
                <label>Username</label>
                <input type="text" id="login-username" name="login-username" autocomplete="username">
                <label>Password</label>
                <input type="password" id="login-password" name="login-password" autocomplete="current-password">
                <input type="hidden" name="login-token" value="<?php echo getToken() ?>">
                <div id="login-error" class="error-message">
                    <?php if (isset($_SESSION['login-error'])) {
                        echo $_SESSION['login-error'];
                        echo '<script>logInError = true</script>';
                        $_SESSION['login-error'] = null;
                    } ?>
                </div>
                <input type="hidden" name="login-submit">
                <button id="login-submit-button" type="submit" name="login-submit-button">Log In</button>
                <div class="center-text">Don't have an account?&nbsp;<span class="link show-signup">Sign up</span>!</div>
            </form>
        </div>
    </div>