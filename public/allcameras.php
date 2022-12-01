<!-- Shows all cameras  -->

<?php
    require_once("../private/database.php");
    require_once("../private/included_functions.php");

    no_SSL(); // switches to http

    $selectQuery = "SELECT * FROM cameras";
    $result = $db->query($selectQuery);

    while ($row = $result->fetch_row()) {
        format_model_name_as_link($row[0], $row[1],"modeldetails.php");
        echo "<br/>";
    };

    $result->free_result();
    $db->close();

?>