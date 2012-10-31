<?php
    ini_set("display_errors", 1);
    include_once("../../../custom_lib/core/dbTools.php");
    include_once("../../../custom_lib/classes/locations.class.php");

    $db = new DBHandler();
    $db->connect();

    $type = $_GET['type'];
    
    if ($type == "locations") {
        $locations = new Locations($db);

        $studios = $locations->getAllStudios();

        $jsStudiosArray = "";

        foreach ($studios as $studio) {
            $jsStudiosArray .= "{ LocationName: '{$studio['displayCode']}', LocationID: '{$studio['nodeID']}' },";
        }
        $jsStudiosArray = rtrim($jsStudiosArray, ",");
        
        echo $jsStudiosArray;
    }
    
    
    $db->close();
?>
