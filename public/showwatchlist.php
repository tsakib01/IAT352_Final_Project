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

    // retrieves cameras in the watchlist based on user email and displays in the Watchlist page
    $selectQuery = "SELECT cid, model, price, url ";
    $selectQuery .= "FROM cameras JOIN images USING(cid) INNER JOIN watchlist USING(cid) ";
    $selectQuery .= "WHERE email='$email'";
    $result = $db->query($selectQuery);

    include_once('../private/shared/public_header.php');


    echo "<main class='watchlist'>";
    echo "<h2 class='display-medium'>Your Watchlist</h2>";

    // displays edit watchlist or done editing submit input based on the state
    echo "<div class='edit-btns' >";
    echo "<input class='edit-watchlist-btn' type='button' name='edit' value='Edit Watchlist'>";
    echo "<input class='done-editing-btn' type='button' name='done' value='Done Editing' style='display:none'>";
    echo "</div>";

    // cameras that are in the watchlist are display as link to details page
    while ($row = $result->fetch_assoc()) {
        $cid=$row['cid'];
        echo "<div class='watchlist-item item$cid'>";
            // formats the cameras as links
            format_model_name_as_link($row['cid'], $row['model'],"cameradetails.php",$row['url'],round($row['price']/10));
            // shows checkout and remove options based on editing and done editing option selected by the user
            echo "<div class='show-watchlist-option' style='display:none'>";  
                // remove from watchlist submit input based on camera id 
                echo "<form class='remove-from-watchlist-form'>\n";
                    echo "<input type=\"hidden\" name=\"cid\" value=$cid>\n";
                    echo "<input class='remove' type=\"submit\" value=\"Remove from Watchlist\">\n";
                echo "</form>\n";
                // checkout link based on camera id
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