<?php
set_include_path("/home/zmilla/includes_img");
require "common/session.php";
require "common/db_connection.php";
require "common/scripts.php";
require "common/queries.php";
require "common/user.php";
require "common/upload.php";
require "common/image_resolver.php";

$page = "homepage";
if (isset($_GET['page'])) $page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">
<!-- This webpage was generated dynamically using PHP and MySQL! -->

<head>
    <!-- Metadata -->
    <title>ImageBucket</title>
    <meta charset="UTF-8">
    <base href='https://img.zrmiller.com/'>
    <link rel="icon" type="image/x-icon" href="icons/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/homepage.css" />
    <link rel="stylesheet" href="css/popups.css" />
    <link rel="stylesheet" href="css/utility.css" />
    <link rel="stylesheet" href="css/images.css" />
    <?php
    // Page specific CSS
    switch ($page) {
        case 'api':
            echo '<link rel="stylesheet" href="css/api.css" />';
            br();
            break;
    }
    ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka&family=Roboto&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://img.zrmiller.com/js/scripts.js"></script>
    <script src="https://img.zrmiller.com/js/validation.js"></script>
    <?php
    // Page specific JS
    switch ($page) {
        case 'api':
            echo '<script src="js/api.js"></script>';
            br();
            break;
    }
    ?>
    <?php if ($_SESSION['logged']) { ?><script src="https://img.zrmiller.com/js/image_upload.js"></script><?php } ?>

</head>

<body>

    <!-- Popups -->
    <?php require "popups/popup_master.php"; ?>

    <div id="page-wrapper">

        <!-- Navbar -->
        <div id="navbar">
            <span id="navbar-left">
                <h3><a href="/" class="navlink title no-select">ImageBucket</a></h3>
                <h3 id="navbar-username" class="navlink"></h3>
            </span>
            <?php require "navbar/navbar_user.php"; ?>
        </div>

        <!-- Page Content -->
        <div id="content">
            <?php
            $pageFile = "page/" . $page . ".php";
            $pageFileFull = stream_resolve_include_path($pageFile);
            $fallbackPage = "page/homepage.php";
            if (file_exists($pageFileFull)) include $pageFile;
            else include $fallbackPage;
            ?>
        </div>

    </div>

</body>

</html>