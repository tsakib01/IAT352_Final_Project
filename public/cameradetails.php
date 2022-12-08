<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    no_SSL();

        if(isset($_SESSION['remove']))
            unset($_SESSION['remove']);
        
        if(isset($_SESSION['edit']))
            unset($_SESSION['edit']);

    $code = trim($_GET['cid']); // gets the camera Id from redirected link
    @$msg = trim($_GET['message']); // gets the message passed with link if not a error suppression is used to prevent throwing an error

    // gets all the attributes of the product using productCode
    $selectQuery = "SELECT * 
                    FROM cameras 
                    WHERE cid = ?";

    $stmt = $db->prepare($selectQuery);
    $stmt->bind_param('d', $code);
    $stmt->execute();
    $stmt->bind_result($cid, $model, $release_year, $max_res, $low_res, $effective_pixels, $zoom_wide, $zoom_tele, $normal_focus, $macro_focus, $storage, $weight, $dimensions, $price);

    require('../private/shared/public_header.php');

    echo "<main class='camera-details'>";

    // displays all the details of the product in different paragraphs
    if ($stmt->fetch()) {
        echo "<h1 class=\"display-medium\">$model</h1>\n";
        echo "<div class='grid-item'>";
        echo "<img src='./images/agfaEphoto1280.png' alt=\"Picture of the camera\" width='1302' height='868'>";

        echo "<div>";
        echo "<p class=\"title-large\"><strong>Released Year: </strong> <br> $release_year</p>";
        echo "<p class=\"title-large\"><strong>Resolution Range: </strong> <br> $low_res" . 'mm - ' . $max_res . "mm</p>";
        echo "<p class=\"title-large\"><strong>Storage: </strong> $storage GB</p>";
        echo "<p class=\"title-large\"><strong>Weight: </strong> $weight grams</p>";
        echo "<p class=\"title-large\"><strong>Dimensions: </strong>$dimensions mm</p>";
        $price = round($price/30);
        echo "<p class=\"title-large\"><strong>Price per day: </strong>$ $price</p>";
        
        echo "<p class=\"title-large\">";
        format_watchlist_action_link($code,"Check Out","checkout.php");
        echo "</p>";

        echo "</div>";
        echo "</div>";
    }

    $stmt->free_result();

    // if the product is not in the watch list then a  Add to Watchlist button will be shown
    if (is_logged_in() && !is_in_watchlist($code)) {
        echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
        echo "<input type=\"hidden\" name=\"cid\" value=$code>\n";
        echo "<input class='title-large' type=\"submit\" value=\"Add To Watchlist\">\n";
        echo "</form>\n";
    } else if (!empty($msg)) { // appropriate message shown if not empty
        echo "<p class='title-large'><br>$msg</p>";
    } else if (is_logged_in())  // if the product is already in the watchlist then a message with an embedded link to the watchlist is displayed
    {
        echo "<p class='title-large'>This model is already in your <a href=\"showwatchlist.php\">watchlist</a>.<p>";
    }



    echo "</main>";

    require('../private/shared/public_footer.php');
    $db->close();

?>