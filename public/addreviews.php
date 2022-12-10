<?php
    // Uses this page to add reviews for a camera 
    require('../private/database.php');
    session_start();
    $cid = $_POST['cid'];
    $nEmail = $_SESSION['valid_user'];
    $nDate = date("Y/m/d");
    $nComments = $_POST['review'];
    $message ="";


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

    $selectQuery = "SELECT email, date, comments FROM reviews WHERE cid=? ORDER BY date";
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