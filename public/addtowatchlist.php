<!-- Uses this page cameras to a watchlist -->
<?php
//only shown in the modeldetails.php page when added to the watchlist
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    no_SSL();

    if(isset($_POST['cid']))
    {
        $cid = !empty($_POST['cid']) ? $_POST['cid'] : "";

        $_SESSION['cid'] = $cid;

        $email = $_SESSION['valid_user'];
        // adds the productCode to the session which was added to the watchlist
        // and unsets the callback_url since user is logged in
        if (isset($_SESSION['callback_url']) && $_SESSION['callback_url'] == 'addtowatchlist.php') {
            $cid = $_SESSION['cid'];
            unset($_SESSION['callback_url'],$_SESSION['cid']);
        }

        $message = "";

        // if item is added from the model details page
        // then it checks if the item is in the watchlist or not
        // if not present in the list, then it is inserted in the watchlist 
        if (!is_in_watchlist($cid)) {
            $insertQuery = "INSERT INTO watchlist (email, cid) 
                      VALUES (?,?)";
            
            $stmt = $db->prepare($insertQuery);
            $stmt->bind_param('sd',$email,$cid);
            $stmt->execute();
                    
            $message = urlencode("The model has been added to your <a href=\"addtowatchlist.php\">watchlist</a>.");
        }
        //fetch the watchlist for the user
        redirect_to("cameradetails.php?cid=$cid&message=$message");
    }

?>