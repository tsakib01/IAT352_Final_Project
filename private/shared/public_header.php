<!doctype html>
<html>

<head>
    <title>Camera Renting Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="../public/css/theme.css" />
    <link rel="stylesheet" type="text/css" href="../public/css/main.css" />
    <script src="../public/js/jquery-3.6.1.js"></script>
</head>

<body>
    <header>
        <a href="../public/index.php" id='logo-nav'><img src="../352-LOGO.png" width="70" height="70" alt="logo" style="float: left"></a>
        <nav class="title-large">
            <a href="../public/allcameras.php">All Cameras</a>
            <a href="../public/showwatchlist.php">Watch List</a>
            <a href="../public/rentals.php">Rental History</a>
            <a href="../public/about.php">About Us</a>
        </nav>
    </header>

    <div class="tooltip">
        <img src="../352-USER.png" alt="user" width="30" height="30" alt="logo">
        <div class="tooltiptext">
            <p class="headline-small">My Account</p>
            <?php
            if (isset($_SESSION['valid_user']))
                echo "<p class=\"title-medium\"><a href=\"../public/user.php\">Manage Account</a></p>
                    <p class=\"title-medium\"><a href=\"../public/signout.php\">Sign Out</a></p>";
            else
                echo "<p class=\"title-medium\"><a href=\"../public/signup.php\">Create Account</a></p>
                        <p class=\"title-medium\"><a href=\"../public/login.php\">Sign In</a></p>";
            ?>
        </div>
    </div>

    <div class="content">