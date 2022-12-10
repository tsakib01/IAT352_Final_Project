<!-- Shows all rentals -->
<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");
    require_SSL();

    include_once('../private/shared/public_header.php');

    echo "<main>";

    // a valid session check is made before 
    // selecting model, from and to date from the database and displaying in the Rentals page
    if(isset($_SESSION['valid_user'])){
        $email = $_SESSION['valid_user'];
        $selectQuery = "SELECT cameras.model, rents.fromDate, rents.toDate 
                        FROM rents 
                        INNER JOIN cameras 
                        ON rents.cid=cameras.cid
                        WHERE rents.email='$email'";

        $result = $db->query($selectQuery);

        while ($row = $result->fetch_row()) {
            echo "<div class='rental-item'>";
            echo "<h2>$row[0]</h2>";
            echo "<p><strong>From :</strong> $row[1]</p>";
            echo "<p><strong>To :</strong> $row[2]</p>";
            echo "</div>";
        }
    }
    else {
        // if a valid session is not found redirects to login page
        $_SESSION['callback_url'] = 'rentals.php';
        redirect_to('login.php');
    }

    echo "</main>";

    include_once('../private/shared/public_footer.php');


?>