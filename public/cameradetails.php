<?php 
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    no_SSL();

    if(isset($_SESSION['remove']))
        unset($_SESSION['remove']);
    
    if(isset($_SESSION['edit']))
        unset($_SESSION['edit']);

    $code = trim($_GET['cid']); // gets the productCode from redirected link
    @$msg = trim($_GET['message']); // gets the message passed with link if not a error suppression is used to prevent throwing an error

    // gets all the attributes of the product using productCode
    $selectQuery = "SELECT * 
                FROM cameras 
                WHERE cid = ?"; 
                
    $stmt = $db->prepare($selectQuery);
    $stmt->bind_param('d',$code);
    $stmt->execute();
    $stmt->bind_result($cid,$model,$release_year,$max_res,$low_res,$effective_pixels,$zoom_wide,$zoom_tele,$normal_focus,$macro_focus,$storage,$weight,$dimensions,$price);

    require('../private/shared/public_header.php');

    echo "<main class='camera-details'>";

    // displays all the details of the product in different paragraphs
    if($stmt->fetch()) {
        echo "<h1>$model</h1>\n";
        echo "<div class='grid-item'>";
        echo "<img src='./images/agfaEphoto1280.png' alt=\"Picture of the camera\" width='1302' height='868'>";

        echo "<div>";
        echo "<p><strong>Released Year:</strong> $release_year</p>";
        echo "<p><strong>Resolution range:</strong> $low_res mm - $max_res mm</p>"; 
        echo "<p><strong>Storage:</strong> $storage GB</p>";
        echo "<p><strong>Weight:</strong> $weight grams</p>";
        echo "<p><strong>Dimensions:</strong>$dimensions mm</p>";
        echo "<p><strong>Price:</strong>$ $price</p>";
        echo "</div>";

        echo "</div>";
    }

    $stmt->free_result();

    // if the product is not in the watch list then a  Add to Watchlist button will be shown
    if (is_logged_in() && !is_in_watchlist($code)) {
        echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
        echo "<input type=\"hidden\" name=\"cid\" value=$code>\n";
        echo "<input type=\"submit\" value=\"Add To Watchlist\">\n";
        echo "</form>\n";
    } 
    else if (!empty($msg)) { // appropriate message shown if not empty
        echo "<p><br>$msg</p>";
    } 
    else if (is_logged_in())  // if the product is already in the watchlist then a message with an embedded link to the watchlist is displayed
    {
        echo "<p>This model is already in your <a href=\"showwatchlist.php\">watchlist</a>.<p>";
    }

    echo "</main>";

    require('../private/shared/public_footer.php');
    $db->close();
?>