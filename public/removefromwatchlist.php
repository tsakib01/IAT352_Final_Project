<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    require_SSL();

    	// if the user is logged in and a product is passed for removing
	// then the product is deleted from the database using email and productCode
	if (!empty($_GET['cid']) && !empty($_SESSION['valid_user'])) {
		$deleteQuery = "DELETE FROM watchlist 
				  		WHERE email=? 
				  		AND cid =?";
		
		$stmt = $db->prepare($deleteQuery);
		$stmt->bind_param('ss',$_SESSION['valid_user'],$_GET['cid']);
		$stmt->execute();			
	}
	// keeps track of the edit mode when removing items from the watchlist
	if(!isset($_SESSION['remove']))
		$_SESSION['remove'] = 'remove';

	redirect_to("showwatchlist.php"); // redirected to the watchlist after removing the product


?>