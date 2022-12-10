<?php
// displays all the items added in the watchlist
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    no_SSL();


    //checks if user is logged in otherwise redirect to login page
    if(!isset($_SESSION['valid_user'])) {
        $_SESSION['callback_url'] = 'showwatchlist.php';
        redirect_to('login.php');
    } 

    $email = $_SESSION['valid_user'];

    $selectQuery = "SELECT cid, model, price, url ";
    $selectQuery .= "FROM cameras JOIN images USING(cid) INNER JOIN watchlist USING(cid) ";
    $selectQuery .= "WHERE email='$email'";
    $result = $db->query($selectQuery);

    include_once('../private/shared/public_header.php');


    echo "<main class='watchlist'>";
    echo "<h2 class='display-medium'>Your Watchlist</h2>";
    echo "<p class='remove-message'></p>";

    echo "<div class='edit-btns' >";
    echo "<input class='edit-watchlist-btn' type='button' name='edit' value='Edit Watchlist'>";
    echo "<input class='done-editing-btn' type='button' name='done' value='Done Editing' style='display:none'>";
    echo "</div>";

    // items that are in the watchlist are display as link to details page
    while ($row = $result->fetch_assoc()) {
        $cid=$row['cid'];
        echo "<div class='watchlist-item item$cid'>";
            format_model_name_as_link($row['cid'], $row['model'],"cameradetails.php",$row['url'],round($row['price']/10));
            echo "<div class='show-watchlist-option' style='display:none'>";    
                echo "<form class='remove-from-watchlist-form'>\n";
                    echo "<input type=\"hidden\" name=\"cid\" value=$cid>\n";
                    echo "<input class='remove' type=\"submit\" value=\"Remove from Watchlist\">\n";
                echo "</form>\n";
                format_watchlist_action_link($row['cid'],"Check Out","checkout.php");
            echo "</div>";
        echo "</div>";
    };
    echo "</main>";

    $result->free_result();
    $db->close();


    echo "<script src='../public/js/showwatchlist.js' ></script>";
    require_once('../private/shared/public_footer.php');

?>