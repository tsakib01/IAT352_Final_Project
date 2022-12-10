<!-- INDEX PAGE  -->
<!-- CHECK header.php and footer.php IN PRIVATE/SHARED DIRECTORY -->
<?php
    require_once("../private/included_functions.php");
    require_once("../private/database.php");

    no_SSL(); // switches to http

    $popularQuery = "SELECT * FROM cameras JOIN images USING(cid) LIMIT 3";
    $popularResult = $db->query($popularQuery);

    require_once("../private/shared/public_header.php");

    echo "<div class='recommend'>";
    echo "<section class='recommend-item'>";
    echo "<h2 class='display-medium'>Popular Rentals</h2>";
    echo "<div class= 'recommend-list'>";
    while ($row = $popularResult->fetch_row()) {
        format_model_name_as_link($row[0], $row[1],"index.php",$row[14],round($row[13]/10));
    };
    echo "</div>";
    echo "</section>";

    echo "<section class='recommend-item'>";
    echo "<h2 class='display-medium'>You May Like</h2>";
    echo "<div class= 'recommend-list'>";
    //show model name as link here
    echo "</div>";
    echo "</section>";
    echo "</div>";

    require_once("../private/shared/public_footer.php");
    $popularResult->free_result();
    $db->close();
?>