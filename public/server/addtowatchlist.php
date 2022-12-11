<?php
    session_start();
    require_once("../../private/database.php");
    require_once("../../private/included_functions.php");
    no_SSL();


    if(isset($_POST['add-to-watchlist']))
    {
        $cid = isset($_POST['cid']) ? $_POST['cid'] : "";

        $email = $_SESSION['valid_user'];

        $message = "";

        // if item is added from the model details page
        // then it checks if the item is in the watchlist or not
        // if not present in the list, then it is inserted in the watchlist 
        if (!is_in_watchlist($cid)) {
            $insertQuery = "INSERT INTO watchlist (email, cid) 
                      VALUES (?,?)";
            
            // retrievs the items from the watchlist from database based on cid
            $stmt = $db->prepare($insertQuery);
            $stmt->bind_param('sd',$email,$cid);
            $stmt->execute();
             
            // a message shown after successfully adding to the watchlist
            $message = "The camera has been added to your <a href=\"showwatchlist.php\">watchlist</a>.";
        }


        $result = array("message" => $message);

        // message is returned in json
        echo json_encode($result);
    }

?>