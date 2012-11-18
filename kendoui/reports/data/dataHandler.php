<?php
    include_once("../../boot.php");
    include_once("classes/locations.class.php");

    $type = $_GET['type'];
    
    if ($type == "locations") {
        $locations = new Locations($db);

        $studios = $locations->getAllStudios();

        foreach ($studios as $studio) {
            $studiosJS[]["text"] = $studio['displayCode'];
            $studiosJS[]["value"] = $studio['nodeID'];
        }
        
        $studiosJS = json_encode($studiosJS);
        echo $studiosJS;
    }
    
    
    $db->close();
?>
