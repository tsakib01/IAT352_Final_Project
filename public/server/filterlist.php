<?php
    require_once('../private/database.php');

    $selectQuery = "Select cid, model, price, url FROM cameras JOIN images USING(cid) ";

    // adding brand filters in array
    $brands = array();
    if(isset($_POST['brand'])){
        for($i = 1; $i <= 19; $i++){
            $bNum = 'brand';
            $bNum .= $i;
            if(isset($_POST["$bNum"])) array_push($brands, $_POST["$bNum"]); 
        }
    }

    // adding year filters in array
    $years = array();
    if(isset($_POST['year'])){
        for($i = 1; $i <= 4; $i++){
            $yNum = 'year';
            $yNum .= $i;
            if(isset($_POST["$yNum"]) && $i != 4) array_push($years, $_POST["$yNum"]);
            if(isset($_POST["$yNum"]) && $i == 4 ) array_push($years, "> 2005"); 
        }
    }

    // adding storage filters in array
    $storages = array();
    if(isset($_POST['storage'])){
        for($i = 1; $i <= 4; $i++){
            $sNum = 'str';
            $sNum .= $i;
            if(isset($_POST["$sNum"]) && $i != 4) array_push($storages, $_POST["$sNum"]); 
            if(isset($_POST["$sNum"]) && $i == 4) array_push($storages, "> 300");
        }
    }

    // adding weight filters in array
    $weights = array();
    if(isset($_POST['weight'])){
        for($i = 1; $i <= 4; $i++){
            $wNum = 'w';
            $wNum .= $i;
            if(isset($_POST["$wNum"]) && $i != 4) array_push($weights, $_POST["$wNum"]); 
            if(isset($_POST["$wNum"]) && $i == 4) array_push($weights, "> 1500");
        }
    }

    // adding price filters in array
    $prices = array();
    if(isset($_POST['price'])){
        for($i = 1; $i <= 4; $i++){
            $pNum = 'p';
            $pNum .= $i;
            if(isset($_POST["$pNum"]) && $i != 4) array_push($prices, $_POST["$pNum"]);
            if(isset($_POST["$pNum"]) && $i == 4) array_push($prices, "> 150"); 
        }
    }

    // items to be used for sorting
    $sortItems = array();
    for($i = 1; $i <= 5; $i++){
        $srtNum = "sort$i";
        if(isset($_POST["$srtNum"]) && $_POST["$srtNum"] == 'year') array_push($sortItems, 'release_year');
        if(isset($_POST["$srtNum"]) && $_POST["$srtNum"] != 'year') array_push($sortItems, $_POST["$srtNum"]); 
    }
    


    // checking if any selection is made
    if (sizeof($brands) > 0 || sizeof($years) > 0 || sizeof($storages) > 0 
        || sizeof($weights) > 0 || sizeof($prices) > 0)
        $selectQuery .= "WHERE ";


    $entryCount = 0;
    // appending brands to sql
    if(sizeof($brands) > 0) {
        $entryCount++;
        for ($i = 0 ; $i < sizeof($brands); $i++){
            if ($i == 0)
                $selectQuery .= "model LIKE '%$brands[$i]%' ";
            else 
                $selectQuery .= "OR model LIKE '%$brands[$i]%' ";
        }
    }

    // appending years to sql
    if(sizeof($years) > 0) {
        $selectQuery .= $entryCount > 0 ? " AND" : "";
        $entryCount++;
        for ($i = 0 ; $i < sizeof($years); $i++){
            if ($i == 0)
                $selectQuery .= " release_year $years[$i] ";
            else
                $selectQuery .= " OR release_year $years[$i] ";
        }
    }

    // appending storages to sql
    if(sizeof($storages) > 0) {
        $selectQuery .= $entryCount > 0 ? " AND" : "";
        $entryCount++;
        for ($i = 0 ; $i < sizeof($storages); $i++){
            if ($i == 0)
                $selectQuery .= " storage $storages[$i] ";
            else
                $selectQuery .= " OR storage $storages[$i] ";
        }
    }

    // appending weights to sql
    if(sizeof($weights) > 0) {
        $selectQuery .= $entryCount > 0 ? " AND" : "";
        $entryCount++;
        for ($i = 0 ; $i < sizeof($weights); $i++){
            if ($i == 0)
                $selectQuery .= " weight $weights[$i] ";
            else
                $selectQuery .= " OR weight $weights[$i] ";
        }
    }

    // appending prices to sql
    if(sizeof($prices) > 0) {
        $selectQuery .= $entryCount > 0 ? " AND" : "";
        for ($i = 0 ; $i < sizeof($prices); $i++){
            if ($i == 0)
                $selectQuery .= " price $prices[$i] ";
            else
                $selectQuery .= " OR price $prices[$i] ";
        }
    }

    if(sizeof($sortItems) > 0) {
        $selectQuery .= " ORDER BY";
        for ($i = 0 ; $i < sizeof($sortItems); $i++)
            if($i == sizeof($sortItems) - 1)
                $selectQuery .= " $sortItems[$i]";
            else
                $selectQuery .= " $sortItems[$i],";
    }

    // echo $selectQuery;

    $stmt = $db->prepare($selectQuery);
    $stmt->execute();
    $stmt->bind_result($cid,$model,$price,$url);

    $filteredResult = array();

    while($stmt->fetch()) {
        $filteredResult[] = array(
                          "cid" => $cid,
                          "model" => $model, 
                          "price" => $price,
                          "url" => $url);
        // echo "Model:$model, Price:$price";
        // echo "<br>";
    }

    echo json_encode($filteredResult);

    

?>