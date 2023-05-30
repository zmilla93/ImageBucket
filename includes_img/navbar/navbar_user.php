<?php if ($_SESSION['logged']) { ?>
    <span id="navbar-right">
        <a href="/u/<?php echo $_SESSION['username'] ?>" id="user" class="big-button navbar-button"><?php echo $_SESSION['username'] ?></a>
        <span class="show-upload big-button navbar-button no-select">Upload</span>
        <form id="logout-form" method="post">
            <span class="big-button navbar-button logout no-select">Logout</button>
                <input type="hidden" name="logout-submit">
        </form>
    </span>
<?php } else { ?>
    <span id="navbar-right">
        <span id="navbar-login-button" class="big-button navbar-button show-login no-select">Log In</span>
        <span id="navbar-signup-button" class="big-button big-button-invert navbar-button show-signup no-select">Sign Up</span>
    </span>
<?php } ?>