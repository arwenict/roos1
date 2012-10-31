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

        foreach ($studios as $studio) {
            $studiosJS["LocationName"] = $studio['displayCode'];
            $studiosJS["LocationID"] = $studio['nodeID'];
        }
        
        $studiosJS = json_encode($studiosJS);
        echo $studiosJS;
    }
    
    
    $db->close();
?>
