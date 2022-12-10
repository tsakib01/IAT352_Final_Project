<?php
    // Uses this page to add reviews for a camera 
    require('../private/database.php');
    session_start();
    $cid = $_POST['cid'];
    $nEmail = $_SESSION['valid_user'];
    $nDate = date("Y/m/d");
    $nComments = $_POST['review'];
    $message ="";


    // if user tries adding a review,
    // a check is made before adding the review in the database for the current product
    // and a message is set depending on the success and failure
    if(isset($_POST['add-review'])){
        try{
            $insertQuery = "INSERT INTO reviews(cid,email,date, comments) VALUES(?,?,?,?)";
            $stmt = $db->prepare($insertQuery);
            $stmt->bind_param('dsss',$cid,$nEmail,$nDate,$nComments);
            $stmt->execute();
            $message = 'You review has been successfully added!!!';
        }
        catch(exception $e)
        {
            $message = 'You already added a review today!!!';
        }
    }

    // retrieves all the reviews of the current product based on cid
    // and the items are returned in json for display in cameradetails.php page
    $selectQuery = "SELECT email, date, comments FROM reviews WHERE cid=? ORDER BY date DESC";
    $stmt = $db->prepare($selectQuery);
    $stmt->bind_param('d', $cid);
    $stmt->execute();
    $stmt->bind_result($email,$date,$comments);


    $reviews = array();

    while($stmt->fetch()) {
        $reviews[] = array(
                          "email" => $email, 
                          "date" => $date,
                          "comments" => $comments);
    }

    $data = array("reviews" => $reviews,
                    "message" => $message);
    echo json_encode($data);
?>