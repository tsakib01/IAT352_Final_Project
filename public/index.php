<?php
    require_once("../private/included_functions.php");
    require_once("../private/database.php");

    no_SSL(); // switches to http
    session_start();

    // determines popularity by selecting cameras from the rentals made by the users based on the number of times it was rented
    // atmost three product are display from the items returned from the database
    $popularQuery = "SELECT * FROM cameras 
                    JOIN images USING(cid) 
                    JOIN(SELECT cid, COUNT(*) AS count FROM `rents` GROUP BY cid) AS totalRent 
                    USING (cid) ORDER BY count DESC LIMIT 3";
    $popularResult = $db->query($popularQuery);

    require_once("../private/shared/public_header.php");

    echo "<main>";

    echo "<div class='recommend'>";
    echo "<section class='recommend-item'>";
    echo "<h2 class='display-medium'>Popular Rentals</h2>";
    echo "<div class='recommend-list'>";
    while ($row = $popularResult->fetch_row()) {
        format_model_name_as_link($row[0], $row[1],"../public/cameradetails.php",$row[14],round($row[13]/10));
    };
    echo "</div>";
    echo "</section>";

    // retrieves last three cameras added in the database and atmost three are displayed
    $lastAddedQuery = "SELECT * FROM cameras JOIN images USING(cid) ORDER BY cid DESC LIMIT 3";
    $lastAddedResult = $db->query($lastAddedQuery);

    echo "<section class='recommend-item'>";
    echo "<h2 class='display-medium'>Last Added</h2>";
    echo "<div class= 'recommend-list'>";
    //show model name as link here
    while ($row = $lastAddedResult->fetch_row()) {
        format_model_name_as_link($row[0], $row[1],"../public/cameradetails.php",$row[14],round($row[13]/10));
    };
    echo "</div>";
    echo "</section>";
    echo "</div>";


    // this is only shown based on the activity of the user
    // if there are enough items rented by the users 
    // then the items that the current never rented will be displayed
    if(is_logged_in()){
    $email = $_SESSION['valid_user'];
    $likeQuery = "SELECT * FROM cameras 
    JOIN images USING(cid) WHERE cid IN
                            (SELECT cid FROM rents WHERE cid NOT IN 
                                                (SELECT cid FROM rents WHERE email='$email') 
                                                    GROUP BY cid) LIMIT 3";
    $likeResult = $db->query($likeQuery);


        echo "<section class='recommend-item'>";
        echo "<h2 class='display-medium'>You May Like</h2>";
        echo "<div class= 'recommend-list'>";
        //show model name as link here
        while ($row = $likeResult->fetch_row()) {
            format_model_name_as_link($row[0], $row[1],"../public/cameradetails.php",$row[14],round($row[13]/10));
        };
        echo "</div>";
        echo "</section>";
        echo "</div>";
    }

    echo "</main>";

    require_once("../private/shared/public_footer.php");

    $db->close();
?>