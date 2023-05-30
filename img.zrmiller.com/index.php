<?php set_include_path("/home/zmilla/includes_img"); ?>
<?php include "common/db_connection.php"; ?>
<?php include "common/scripts.php"; ?>
<?php include "common/user.php"; ?>
<?php include "common/upload.php"; ?>
<?php include "common/image_resolver.php"; ?>

<!DOCTYPE html>
<html>
<!-- This webpage was generated dynamically using PHP and MySQL! -->

<head>
    <!-- Metadata -->
    <title>ImageBucket</title>
    <base href='https://img.zrmiller.com/'>
    <link rel="icon" type="image/x-icon" href="icons/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/homepage.css" />
    <link rel="stylesheet" href="css/popups.css" />
    <link rel="stylesheet" href="css/utility.css" />
    <link rel="stylesheet" href="css/images.css" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://img.zrmiller.com/js/scripts.js"></script>
    <script src="https://img.zrmiller.com/js/validation.js"></script>
    <?php if ($_SESSION['logged']) { ?><script src="https://img.zrmiller.com/js/image_upload.js"></script><?php } ?>

</head>

<body>

    <!-- Popups -->
    <?php include "popups/popup_master.php"; ?>

    <div id="page-wrapper">

        <!-- Navbar -->
        <div id="navbar">
            <span id="navbar-left">
                <h3><a href="/" class="navlink title no-select">ImageBucket</a></h3>
                <h3 id="navbar-username" class="navlink"></h3>
            </span>
            <?php include "navbar/navbar_user.php"; ?>
        </div>

        <!-- Page Content -->
        <div id="content">
            <?php if (isset($_GET['profile'])) {
                include "page/profile.php";
            } else if (isset($_GET['image_raw'])) {
                include "page/image.php";
            } else if (isset($_GET['error'])) {
                include "page/404.php";
            } else {
                include "page/homepage.php";
            }
            ?>
        </div>

    </div>

</body>

</html>