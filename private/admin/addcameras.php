<?php
    require_once('../database.php');


    $insertQuery = "INSERT INTO cameras(model,release_year,max_res,low_res,effective_pixels,zoom_wide,zoom_tele,normal_focus,macro_focus,storage,weight,dimensions,price) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $db->prepare($insertQuery);
    $stmt->bind_param('ssddddddddddd',$model,$release_year,$max_res,$low_res,$effective_pixels,$zoom_wide,$zoom_tele,$normal_focus,$macro_focus,$storage,$weight,$dimensions,$price);

    // if (($handle = fopen("camera_dataset.csv", "r")) !== FALSE) 
    // {
    //     $row = 0;
    //     while (($data = fgetcsv($handle)) !== FALSE) {

    //             if($row > 0){
    //                 echo "<p> line $row: </p>";

    //                     $model = $data[0];
    //                     $release_year = $data[1];
    //                     $max_res = $data[2];
    //                     $low_res = $data[3];
    //                     $effective_pixels = $data[4];	
    //                     $zoom_wide = $data[5];
    //                     $zoom_tele = $data[6];
    //                     $normal_focus = $data[7];	
    //                     $macro_focus = $data[8];	
    //                     $storage = $data[9];
    //                     $weight = $data[10];	
    //                     $dimensions = $data[11];	
    //                     $price = $data[12];

    //                     echo $model.", ".$release_year.", ".$max_res.", ".$low_res.", ".$effective_pixels.", ".$zoom_wide.", ".$zoom_tele.", ".$normal_focus.", ".$macro_focus.", ".$storage
    //                     .", ".$weight.", ".$dimensions.", ".$price;

    //                     $stmt->execute();

    //                     echo "<br/>";
    //             }
    //             $row++;

    //         }
    //         fclose($handle);
    // }

?>