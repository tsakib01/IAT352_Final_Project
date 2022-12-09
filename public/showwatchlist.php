<!-- Shows cameras in the watchlist -->

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

    if (isset($message)) echo "<p>$message</p>";

    echo "<main class='watchlist'>";
    echo "<h2 class='display-medium'>Your Watchlist</h2>";

    // if edit option is clicked a session will be created with edit
    // and unset the editing done session if exists
    if(isset($_POST['edit'])){
        $_SESSION['edit'] = $_POST['edit'];
        if(isset($_SESSION['done']))
            unset($_SESSION['done']); 
    }

    // checks if both edit and done option are submitted
    // if not then edit button will be display
    if(!isset($_POST['edit']) && !isset($_SESSION['done']) && !isset($_SESSION['remove'])){
        echo "<form action='showwatchlist.php' method='post'>";
        echo "<input class='title-large' type='submit' name='edit' value='Edit Watchlist'>";
        echo "</form>";
    }


    // checks if editing is not done and edit session is available 
    // displays the Done Editing button
    if(!isset($_POST['done']) && isset($_SESSION['edit'])){
        echo "<form action='showwatchlist.php' method='post'>";
        echo "<input class='title-large' type='submit' name='done' value='Done Editing'>";
        echo "</form>";
    }

    // checks if the watchlist is in editable mode or not
    // if not in edit mode then edit button is shown
    if(!isset($_POST['edit']) && isset($_SESSION['done'])){
        echo "<form action='showwatchlist.php' method='post'>";
        echo "<input class='title-large' type='submit' name='edit' value='Edit Watchlist'>";
        echo "</form>";
    }

    // if editing done is clicked a session will be create with done
    // if edit session exists then it will be unset
    // a remove session is checked to make sure the editing mode remains after redirect from removefromwatchlist.php
    if(isset($_POST['done'])){
        $_SESSION['done'] = $_POST['done'];
        if(isset($_SESSION['edit']))
            unset($_SESSION['edit']);
        
        if(isset($_SESSION['remove']))
            unset($_SESSION['remove']);
    }

    // items that are in the watchlist are display as link to details page
    // if edit session is found then the remove option will be display beside each item
    while ($row = $result->fetch_assoc()) {

        echo "<div class='watchlist-item'>";
        format_model_name_as_link($row['cid'], $row['model'],"cameradetails.php",$row['url'],$row['price']);
        if(isset($_SESSION['edit'])){
            format_watchlist_action_link($row['cid'],"Remove from Watchlist","removefromwatchlist.php");
        }
        format_watchlist_action_link($row['cid'],"Check Out","checkout.php");
        echo "</div>";
    };


    echo "</main>";
    require_once('../private/shared/public_footer.php');

    $result->free_result();
    $db->close();

?>