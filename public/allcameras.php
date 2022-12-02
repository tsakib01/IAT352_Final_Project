<!-- Shows all cameras  -->

<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");

    no_SSL(); // switches to http

    $selectQuery = "SELECT * FROM cameras";
    $result = $db->query($selectQuery);


    require("../private/shared/public_header.php");

    echo "<main>";
    echo "<h1>Camera List</h1>";

    echo "<div class='camera-list'>";
    while ($row = $result->fetch_row()) {
        format_model_name_as_link($row[0], $row[1],"cameradetails.php","./images/agfaEphoto1280.PNG",$row[13]);
    };

    echo "</div>";
    echo "</main>";

    require("../private/shared/public_footer.php");

    $result->free_result();
    $db->close();

?>