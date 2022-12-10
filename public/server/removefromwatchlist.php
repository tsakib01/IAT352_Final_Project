<?php
    session_start();
    require_once("../private/database.php");

    // if the user is logged in and a camera id is passed for removing
	// then the camera is deleted from the database using email and camera id
	$cid = "";

	if (!empty($_POST['cid']) && !empty($_SESSION['valid_user'])) {
		$cid = $_POST['cid'];
		$email = $_SESSION['valid_user'];
		$deleteQuery = "DELETE FROM watchlist 
				  		WHERE email=? 
				  		AND cid =?";
		
		$stmt = $db->prepare($deleteQuery);
		$stmt->bind_param('ss',$email,$cid);
		$stmt->execute();			
	}

	$result = array("cid"=>$cid);

	echo json_encode($result);
?>