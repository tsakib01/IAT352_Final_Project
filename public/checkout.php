<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    require_SSL();

    include_once('../private/shared/public_header.php');

    echo "<main class='checkout'>";

    if(isset($_GET['cid'])){
        $code = trim($_GET['cid']); // gets the camera Id from redirected link
    }

    $isValid = true;
    $email = "";
    $cid = 0;
    $from = "";
    $to = "";


    // a check is made to ensure if checkout option was clicked  
    // then assigns the variables email, cid, from and to based on the submission
    if (isset($_POST['checkout'])){
        $email = $_SESSION['valid_user'];
        $cid = $_POST['cid'];
        $from = $_POST['from'];
        $to = $_POST['to'];
    }

    if (isset($_POST['checkout'])){

        if($from == ""){
            echo "<p>From entry missing</p>";
            $isValid = false;
        }

        if($to == ""){
            echo "<p>To entry missing</p>";
            $isValid = false;
        }
            
        if($from > $to && $isValid) {
            echo "<p>From can't be greater than to </p>";
            $isValid = false;
        }

    }


    // checks if already booked around that date
    if (isset($_POST['checkout']) && $isValid){

        $selectQuery = "SELECT * FROM rents 
                        WHERE cid=$cid 
                        AND '$from' BETWEEN fromDate AND toDate
                        OR cid=$cid AND '$to' BETWEEN fromDate AND toDate";

        $result = $db->query($selectQuery);
        
        $count = 0;

        while($row = $result->fetch_assoc())
            $count++;

        $isValid = $count > 0 ? false : true;

        if(!$isValid){
            echo "<p>The camera is not available in that date range.</p>"; 
            echo "<p>Try a different date range or a different camera.</p>";
        }

        $result->free_result();
    }

    // books the user
    if (isset($_POST['checkout']) && $isValid){

        $insertQuery = "INSERT INTO rents (email,cid,fromDate,toDate) VALUES (?,?,?,?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param('sdss',$email,$cid,$from,$to);
        $stmt->execute();

        echo "<h1>Your booking has been successful.</h1>";

    }

    if(!isset($_POST['checkout'])){
        $selectQuery = "SELECT C.model
        FROM cameras C
        WHERE C.cid = ?"; 
        
        $stmt = $db->prepare($selectQuery);
        $stmt->bind_param('d',$code);
        $stmt->execute();
        $stmt->bind_result($model);


        if($stmt->fetch()) {
            echo "<h1>$model</h1>\n";
        }

        if(isset($_SESSION['valid_user'])) {

            echo "<form action='checkout.php' method='post'>";

            echo "<label><p>From</p>";
            echo "<input type='date' name='from' placeholder='From'>";
            echo "</label>";

            echo "<label><p>To</p>";
            echo "<input type='date' name='to' placeholder='To'>";
            echo "</label>";

            echo "<input type='hidden' name='cid' value='$code'>";

            echo "<input id='checkout' type='submit' name='checkout' value='Check Out'>";
            echo "</form>";
        }
    }

    echo "</main>";

    $db->close();
    include_once('../private/shared/public_footer.php');

?>