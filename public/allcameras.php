<!-- Shows all cameras  -->

<?php
    session_start();
    require_once("../private/database.php");
    require_once("../private/included_functions.php");

    no_SSL(); // switches to http

    $selectQuery = "SELECT * FROM cameras JOIN images USING(cid)";
    $result = $db->query($selectQuery);


    require("../private/shared/public_header.php");

    echo "<main>";
    echo "<h1 class=\"display-medium\">Camera List</h1>";
    //------------------FILTERING STARTS HERE-----------------------------------------------------------------------------
    echo "<form class='apply-filter'>";
        echo "<div class='filter-sort'>";
            echo "<div class='filter'>";
                //select option to filter
                echo "<div class='filter-item1-option'>";
                    echo "<span>Filter by:</span>";
                    echo "<ul class='filter-option' style='list-style-type:none; display:none'>";
                        addCheckboxOptionAsListWithFunction('brand', 'Brand', 'isBrandSelected(this)');
                        addCheckboxOptionAsListWithFunction('year', 'Year', 'isYearSelected(this)');
                        addCheckboxOptionAsListWithFunction('storage', 'Storage', 'isStorageSelected(this)');
                        addCheckboxOptionAsListWithFunction('weight', 'Weight', 'isWeightSelected(this)');
                        addCheckboxOptionAsListWithFunction('price', 'Price', 'isPriceSelected(this)');
                    echo "</ul>";
                echo "</div>";
                
                // show selected brand
                echo "<div class='filter-item2-brand' style='display:none'>";
                    echo "<span>Brand</span>";
                    echo "<ul class='filter-brand' style='list-style-type:none'>";
                        addCheckboxOptionAsList('brand1', 'Agfa');
                        addCheckboxOptionAsList('brand2', 'Canon');
                        addCheckboxOptionAsList('brand3', 'Epson');
                        addCheckboxOptionAsList('brand4', 'Fujifilm');
                        addCheckboxOptionAsList('brand5', 'HP');
                        addCheckboxOptionAsList('brand6', 'JVC');
                        addCheckboxOptionAsList('brand7', 'Kodak');
                        addCheckboxOptionAsList('brand8', 'Kyocera');
                        addCheckboxOptionAsList('brand9', 'Leica');
                        addCheckboxOptionAsList('brand10', 'Nikon');
                        addCheckboxOptionAsList('brand11', 'Olympus');
                        addCheckboxOptionAsList('brand12', 'Panasonic');
                        addCheckboxOptionAsList('brand13', 'Pentax');
                        addCheckboxOptionAsList('brand14', 'Ricoh');
                        addCheckboxOptionAsList('brand15', 'Samsung');
                        addCheckboxOptionAsList('brand16', 'Sanyo');
                        addCheckboxOptionAsList('brand17', 'Sigma');
                        addCheckboxOptionAsList('brand18', 'Sony');
                        addCheckboxOptionAsList('brand19', 'Toshiba');
                    echo "</ul>";
                echo "</div>";

                // show selected year
                echo "<div class='filter-item3-year' style='display:none'>";
                    echo "<span>Year</span>";
                    echo "<ul class='filter-year' style='list-style-type:none'>";
                        addCheckboxOptionAsList('year1', 'between 1990 and 1995');
                        addCheckboxOptionAsList('year2', 'between 1995 and 2000');
                        addCheckboxOptionAsList('year3', 'between 2000 and 2005');
                        addCheckboxOptionAsList('year4', 'between 2005 and above');
                    echo "</ul>";
                echo "</div>";

                // show selected storage
                echo "<div class='filter-item4-storage' style='display:none'>";
                    echo "<span>Storage(GB)</span>";
                    echo "<ul class='filter-storage' style='list-style-type:none'>";
                        addCheckboxOptionAsList('str1', 'between 0 and 100');
                        addCheckboxOptionAsList('str2', 'between 100 and 200');
                        addCheckboxOptionAsList('str3', 'between 200 and 300');
                        addCheckboxOptionAsList('str4', 'between 300 and above');
                    echo "</ul>";
                echo "</div>";

                
                // show selected weight
                echo "<div class='filter-item5-weight' style='display:none'>";
                    echo "<span>Weight(Grams)</span>";
                    echo "<ul class='filter-weight' style='list-style-type:none'>";
                        addCheckboxOptionAsList('w1', 'between 800 and 1000');
                        addCheckboxOptionAsList('w2', 'between 1000 and 1200');
                        addCheckboxOptionAsList('w3', 'between 1200 and 1400');
                        addCheckboxOptionAsList('w4', 'between 1500 and above');
                    echo "</ul>";
                echo "</div>";

                // show selected price
                echo "<div class='filter-item6-price' style='display:none'>";
                    echo "<span>Price(USD)</span>";
                    echo "<ul class='filter-price' style='list-style-type:none'>";
                        addCheckboxOptionAsList('p1', 'between 0 and 50');
                        addCheckboxOptionAsList('p2', 'between 50 and 100');
                        addCheckboxOptionAsList('p3', 'between 100 and 150');
                        addCheckboxOptionAsList('p4', 'between 150 and above');
                    echo "</ul>";
                echo "</div>";
                
            echo "</div>";

            echo "<div class='sort'>";
                echo "<span>Sort by:</span>";
                echo "<ul class='sort-items' style='list-style-type:none; display:none'>";
                    addCheckboxOptionAsList('sort1', 'brand');
                    addCheckboxOptionAsList('sort2', 'year');
                    addCheckboxOptionAsList('sort3', 'storage');
                    addCheckboxOptionAsList('sort4', 'weight');
                    addCheckboxOptionAsList('sort4', 'price');
                echo "</ul>";
            echo "</div>";
        echo "</div>";
    echo "</form>";
    echo "<button id='apply-filter-btn' type='submit'>Apply</button>";
    //------------------FILTERING ENDS HERE-----------------------------------------------------------------------------

    echo "<div class='camera-list'>";
    while ($row = $result->fetch_assoc()) {
        format_model_name_as_link($row['cid'], $row['model'],"cameradetails.php",$row['url'],round($row['price']/30));
    };

    echo "</div>";
    echo "</main>";

    require("../private/shared/public_footer.php");

    $result->free_result();
    $db->close();

    echo "<script src='../public/js/allcameras.js'></script>";
?>